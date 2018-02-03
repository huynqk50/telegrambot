<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_to_attribute".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $attribute_id
 *
 * @property Product $product
 * @property ProductAttribute $attribute
 */
class ProductToAttribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_to_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'attribute_id'], 'required'],
            [['product_id', 'attribute_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductAttribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
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
            'attribute_id' => 'Attribute ID',
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
    public function getProductAttribute()
    {
        return $this->hasOne(ProductAttribute::className(), ['id' => 'attribute_id']);
    }
}
