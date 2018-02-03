<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_customization".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @property string $label
 * @property integer $review_score
 * @property integer $order_quantity
 * @property integer $sold_quantity
 * @property integer $available_quantity
 * @property integer $total_quantity
 * @property integer $price
 * @property integer $original_price
 * @property integer $total_revenue
 *
 * @property Product $product
 * @property ProductCustomizationToOption[] $productCustomizationToOptions
 * @property ProductImage[] $productImages
 * @property ProductTracking[] $productTrackings
 * @property PurchaseOrderDetail[] $purchaseOrderDetails
 */
class ProductCustomization extends \common\models\ProductCustomization
{
    public function isStockAvailable()
    {
        return $this->available_quantity > 0;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_customization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'name'], 'required'],
            [['product_id', 'review_score', 'order_quantity', 'sold_quantity', 'available_quantity', 'total_quantity', 'price', 'original_price', 'total_revenue', 'sort_order'], 'integer'],
            [['name', 'label'], 'string', 'max' => 511],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
            'label' => 'Label',
            'review_score' => 'Review Score',
            'order_quantity' => 'Order Quantity',
            'sold_quantity' => 'Sold Quantity',
            'available_quantity' => 'Available Quantity',
            'total_quantity' => 'Total Quantity',
            'price' => 'Price',
            'original_price' => 'Original Price',
            'total_revenue' => 'Total Revenue',
        ];
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
    public function getProductCustomizationToImages()
    {
        return $this->hasMany(ProductCustomizationToImage::className(), ['customization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['id' => 'image_id'])->via('productCustomizationToImages');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCustomizationToOptions()
    {
        return $this->hasMany(ProductCustomizationToOption::className(), ['customization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductOptions()
    {
        return $this->hasMany(ProductOption::className(), ['id' => 'option_id'])->via('productCustomizationToOptions');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTrackings()
    {
        return $this->hasMany(ProductTracking::className(), ['customization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::className(), ['product_customization_id' => 'id']);
    }

}
