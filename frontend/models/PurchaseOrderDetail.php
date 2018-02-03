<?php

namespace frontend\models;

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
            [['product_customization_name', 'product_name', 'product_description'], 'string', 'max' => 511],
            [['purchase_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseOrder::className(), 'targetAttribute' => ['purchase_order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['product_customization_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCustomization::className(), 'targetAttribute' => ['product_customization_id' => 'id']],
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
