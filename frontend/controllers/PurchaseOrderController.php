<?php

namespace frontend\controllers;

use common\utils\Json;
use frontend\models\Product;
use frontend\models\ProductCustomization;
use frontend\models\PurchaseOrder;
use frontend\models\PurchaseOrderDetail;
use Yii;
use yii\helpers\Url;

class PurchaseOrderController extends BaseController
{
    const CART_KEY = 'Shopping Cart';
    const REVIEW_KEY = 'PurchaseOrder ReviewChecklist';
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionReviewChecklist()
    {
        $review = Yii::$app->session->get(self::REVIEW_KEY, []);
        if (!self::validateReviewData($review)) {
            $review = ['customer_info' => [], 'list_items' => []];
            Yii::$app->session->set(self::REVIEW_KEY, $review);
        }

        $this->breadcrumbs[] = ['label' => 'Đặt hàng thành công', 'url' => Url::current([], true)];

        return $this->render('reviewChecklist', ['review' => $review]);
    }
    
    public function actionAddToCart()
    {
        if (!Yii::$app->request->isPost) {
            return -1;
        }
        
        if (!Yii::$app->session->has(self::CART_KEY)) {
            Yii::$app->session->set(self::CART_KEY, []);
        }
        
        $cart = Yii::$app->session->get(self::CART_KEY);
        
        $cart_item = json_decode(Yii::$app->request->post('CartItem'));
        
        $check = false;
        
        foreach ($cart as &$item) {
            if ($item->product_id == $cart_item->product_id
                && $item->product_customization_id == $cart_item->product_customization_id)
            {
                $item->quantity += $cart_item->quantity;
                $check = true;
                break;
            }
        }
        
        if (!$check) {
            $cart[] = $cart_item;
        }
        
        Yii::$app->session->set(self::CART_KEY, $cart);

        return count($cart);
    }
    
    public function actionCartCheckout()
    {
        if(!Yii::$app->session->has(self::CART_KEY)) {
            Yii::$app->session->set(self::CART_KEY, []);
        }
        
        $cart = Yii::$app->session->get(self::CART_KEY);
        
        $data = [];
        
        $edited = false;
        
        foreach ($cart as $key => $item) {
            if (!self::validateCartItem($item)) {
                unset($cart[$key]);
                $edited = true;
                continue;
            }
            if (!($product = Product::findOne($item->product_id))) {
                continue;
            }
            $customization = ProductCustomization::find()->where(['id' => $item->product_customization_id])->one();
            $data[] = [
                'product_id' => $product->id,
                'product_code' => $product->code,
                'product_name' => $product->name,
                'product_customization_id' => $item->product_customization_id,
                'product_customization_name' => ($customization ? $customization->name : ''),
                'quantity' => $item->quantity,
                'image' => $customization && !empty($images = $customization->getProductImages()->orderBy('sort_order asc')->all())
                    ? $images[0]->getImage([], Product::IMAGE_SMALL)
                    : $product->getImage([], Product::IMAGE_SMALL),
                'link' => $product->getLink(),
                'price' => $product->price == null ? 0 : $product->price,
                'available_quantity' => $customization
                    ? $customization->available_quantity
                    : $product->available_quantity
            ];

        }
        
        if ($edited) {
            Yii::$app->session->set(self::CART_KEY, $cart);
        }

        $order = new PurchaseOrder;

        if (Yii::$app->request->isPost) {
            if (Yii::$app->session->get(self::CART_KEY, []) == []) {
                Yii::$app->session->set(self::CART_KEY, []);
                $order->addError('handle_error', 'Giỏ hàng đang rỗng. Vui lòng mua thêm sản phẩm.');
            } else {
                $now = time();
                $order->load(Yii::$app->request->post());
                $order->status = PurchaseOrder::STATUS_NEW;
                $order->created_at = $now;
                $order->code = PurchaseOrder::generateCode();

                $order->save();

                $cart = Yii::$app->session->get(self::CART_KEY);

                $details = [];

                $edited = false;

                $customizations = [];
                foreach ($cart as $key => $item) {
                    if (!self::validateCartItem($item)) {
                        unset($cart[$key]);
                        $edited = true;
                        continue;
                    }
                    if (!($product = Product::findOne($item->product_id))) {
                        continue;
                    }
                    $customization = ProductCustomization::find()->where(['id' => $item->product_customization_id])->one();
                    $details[] = [
                        'purchase_order_id' => $order->id,
                        'purchase_order_code' => $order->code,
                        'product_id' => $product->id,
                        'product_code' => $product->code,
                        'product_name' => $product->name,
                        'product_description' => $product->description,
                        'product_customization_id' => $customization ? $customization->id : null,
                        'product_customization_name' => $customization ? $customization->name : null,
                        'unit_price' => $product->price == null ? 0 : $product->price,
                        'quantity' => $item->quantity,
                        'discount' => (float) $product->discountPercent(2),
                        'img_tag' => $customization && !empty($images = $customization->getProductImages()->orderBy('sort_order asc')->all())
                            ? $images[0]->img([], Product::IMAGE_SMALL)
                            : $product->img([], Product::IMAGE_SMALL),
                        'a_tag' => $product->a(['class' => 'name link'])
                    ];
                    if ($customization) {
                        $customization->order_quantity += $item->quantity;
                        $customizations[$customization->id] = $customization;
                    }
                }

                $success = false;

                foreach ($details as $item) {
                    $order_detail = new PurchaseOrderDetail;
                    $order_detail->load(['PurchaseOrderDetail' => $item]);
                    if ($order_detail->save()) {
                        if ($item['product_customization_id'] != null) {
                            $customizations[$item['product_customization_id']]->save();
                        }
                        $success = true;
                    }
                }

                if ($success) {
                    Yii::$app->session->set(self::CART_KEY, []);
                    Yii::$app->session->set(self::REVIEW_KEY, [
                        'customer_info' => $order->attributes,
                        'list_items' => $details
                    ]);

                    return $this->redirect(['review-checklist']);
                } else {
                    if ($edited) {
                        Yii::$app->session->set(self::CART_KEY, $cart);
                    }
                    $order->delete();

                    $order->addError('handle_error', 'Giỏ hàng đang rỗng hoặc có lỗi xảy ra. Vui lòng thử lại hoặc liên hệ trực tiếp với chúng tôi. Xin cảm ơn!');
                }
            }
        }

        $this->link_canonical = Url::current([], true);
        $this->breadcrumbs[] = ['label' => 'Giỏ hàng', 'url' => $this->link_canonical];
        
        return $this->render('cartCheckout', ['data' => $data, 'order' => $order]);
    }
    
    public function actionUpdateCartData()
    {
        if (!Yii::$app->request->isPost) {
            return -1;
        }
        
        if(!Yii::$app->session->has(self::CART_KEY)) {
            Yii::$app->session->set(self::CART_KEY, []);
        }
        
        $data = json_decode(Yii::$app->request->post('CartData'));
        
        Yii::$app->session->set(self::CART_KEY, $data);
        
        return count($data);
    }
    
    public static function validateCartItem($cart_item)
    {
        if (!property_exists($cart_item, 'product_id') || !property_exists($cart_item, 'product_customization_id') || !property_exists($cart_item, 'quantity')) {
            return false;
        }
        
        if (!is_numeric($cart_item->product_id) || !is_numeric($cart_item->product_customization_id) || !is_numeric($cart_item->quantity)) {
            return false;
        }
        
        if ($cart_item->product_id <= 0 || $cart_item->product_customization_id <= 0 || $cart_item->quantity <= 0) {
            return false;
        }
        
        return true;
    }
    
    public static function validateReviewData($review)
    {
        if (!isset($review['customer_info']) || !isset($review['list_items'])) {
            return false;
        }
        
        if (!is_array($review['customer_info']) || !is_array($review['list_items'])) {
            return false;
        }
        
        return true;
    }
}
