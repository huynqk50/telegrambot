<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_image".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $image
 * @property string $image_path
 * @property string $color
 * @property integer $sort_order
 *
 * @property ProductCustomizationToImage[] $productCustomizationToImages
 * @property Product $product
 */
class ProductImage extends \common\models\ProductImage
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'image', 'image_path'], 'required'],
            [['product_id', 'sort_order'], 'integer'],
            [['image', 'image_path'], 'string', 'max' => 511],
            [['color'], 'string', 'max' => 127],
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
            'image' => 'Image',
            'image_path' => 'Image Path',
            'color' => 'Color',
            'sort_order' => 'Sort Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCustomizationToImages()
    {
        return $this->hasMany(ProductCustomizationToImage::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
