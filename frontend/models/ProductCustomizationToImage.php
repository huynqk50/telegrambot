<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_customization_to_image".
 *
 * @property integer $id
 * @property integer $customization_id
 * @property integer $image_id
 *
 * @property ProductCustomization $customization
 * @property ProductImage $image
 */
class ProductCustomizationToImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_customization_to_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customization_id', 'image_id'], 'required'],
            [['customization_id', 'image_id'], 'integer'],
            [['customization_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCustomization::className(), 'targetAttribute' => ['customization_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductImage::className(), 'targetAttribute' => ['image_id' => 'id']],
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
            'image_id' => 'Image ID',
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
    public function getImage()
    {
        return $this->hasOne(ProductImage::className(), ['id' => 'image_id']);
    }
}
