<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "purchase_order_detail".
 *
 * @property integer $id
 * @property integer $purchase_order_id
 * @property integer $product_customization_id
 * @property integer $product_id
 * @property string $purchase_order_code
 * @property string $product_code
 * @property string $product_customization_name
 * @property string $product_name
 * @property string $product_description
 * @property string $product_color
 * @property string $product_style
 * @property string $product_size
 * @property string $product_weight
 * @property string $product_model
 * @property integer $unit_price
 * @property integer $quantity
 * @property double $discount
 *
 * @property PurchaseOrder $purchaseOrder
 * @property Product $product
 * @property ProductCustomization $productCustomization
 */
class PurchaseOrderDetail extends \common\models\PurchaseOrderDetail
{

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new PurchaseOrderDetail();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'PurchaseOrderDetail';
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            if ($model->save()) {
                if ($log) {
                    $log->object_pk = $model->id;
                    $log->is_success = 1;
                    $log->save();
                }
                return $model;
            }
            Dump::errors($model->errors);
            return;
        }
        return false;
    }
    
    /**
    * function ->update2 ($data)
    */
    public function update2 ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;   
        if ($this->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Update';
                $log->object_class = 'PurchaseOrderDetail';
                $log->object_pk = $this->id;
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            if ($this->save()) {
                if ($log) {
                    $log->is_success = 1;
                    $log->save();
                }
                return $this;
            }
        }
        return false;
    }
    
    /**
    * function ->delete ()
    */
    public function delete ()
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;    
        if ($log = new UserLog()) {
            $log->username = $username;
            $log->action = 'Delete';
            $log->object_class = 'PurchaseOrderDetail';
            $log->object_pk = $this->id;
            $log->created_at = $now;
            $log->is_success = 0;
            $log->save();
        }
        if(parent::delete()) {
            if ($log) {
                $log->is_success = 1;
                $log->save();
            }
            return true;
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_order_id', 'product_id', 'unit_price', 'quantity'], 'required'],
            [['purchase_order_id', 'product_customization_id', 'product_id', 'unit_price', 'quantity'], 'integer'],
            [['discount'], 'number'],
            [['purchase_order_code', 'product_code', 'product_color', 'product_style', 'product_size', 'product_weight', 'product_model'], 'string', 'max' => 255],
            [['product_customization_name', 'product_name', 'product_description'], 'string', 'max' => 511]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_order_id' => 'Purchase Order ID',
            'product_customization_id' => 'Product Customization ID',
            'product_id' => 'Product ID',
            'purchase_order_code' => 'Purchase Order Code',
            'product_code' => 'Product Code',
            'product_customization_name' => 'Product Customization Name',
            'product_name' => 'Product Name',
            'product_description' => 'Product Description',
            'product_color' => 'Product Color',
            'product_style' => 'Product Style',
            'product_size' => 'Product Size',
            'product_weight' => 'Product Weight',
            'product_model' => 'Product Model',
            'unit_price' => 'Unit Price',
            'quantity' => 'Quantity',
            'discount' => 'Discount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::className(), ['id' => 'purchase_order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCustomization()
    {
        return $this->hasOne(ProductCustomization::className(), ['id' => 'product_customization_id']);
    }
}
