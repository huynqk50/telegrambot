<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_customization_to_option".
 *
 * @property integer $id
 * @property integer $customization_id
 * @property integer $option_id
 *
 * @property ProductCustomization $customization
 * @property ProductOption $option
 */
class ProductCustomizationToOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_customization_to_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customization_id', 'option_id'], 'required'],
            [['customization_id', 'option_id'], 'integer'],
            [['customization_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCustomization::className(), 'targetAttribute' => ['customization_id' => 'id']],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductOption::className(), 'targetAttribute' => ['option_id' => 'id']],
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
            'option_id' => 'Option ID',
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
    public function getOption()
    {
        return $this->hasOne(ProductOption::className(), ['id' => 'option_id']);
    }
}
