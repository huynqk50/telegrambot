<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_tracking".
 *
 * @property integer $id
 * @property integer $customization_id
 * @property integer $product_id
 * @property integer $order_quantity
 * @property integer $sold_quantity
 * @property integer $available_quantity
 * @property integer $total_quantity
 * @property integer $price
 * @property integer $original_price
 * @property integer $created_at
 * @property string $created_by
 *
 * @property ProductCustomization $customization
 * @property Product $product
 */
class ProductTracking extends \common\models\ProductTracking
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_tracking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customization_id', 'product_id', 'order_quantity', 'sold_quantity', 'available_quantity', 'total_quantity', 'price', 'original_price', 'created_at'], 'integer'],
            [['created_by'], 'string', 'max' => 255],
            [['customization_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCustomization::className(), 'targetAttribute' => ['customization_id' => 'id']],
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
            'customization_id' => 'Customization ID',
            'product_id' => 'Product ID',
            'order_quantity' => 'Order Quantity',
            'sold_quantity' => 'Sold Quantity',
            'available_quantity' => 'Available Quantity',
            'total_quantity' => 'Total Quantity',
            'price' => 'Price',
            'original_price' => 'Original Price',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomization()
    {
        return $this->hasOne(ProductCustomization::className(), ['id' => 'customization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
