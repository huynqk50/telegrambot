<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_option".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property integer $group_id
 * @property integer $sort_order
 *
 * @property ProductCustomizationToOption[] $productCustomizationToOptions
 * @property ProductOptionGroup $group
 */
class ProductOption extends \common\models\ProductOption
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'group_id'], 'required'],
            [['group_id', 'sort_order'], 'integer'],
            [['name', 'label'], 'string', 'max' => 511],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductOptionGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'label' => 'Label',
            'group_id' => 'Group ID',
            'sort_order' => 'Sort Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCustomizationToOptions()
    {
        return $this->hasMany(ProductCustomizationToOption::className(), ['option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(ProductOptionGroup::className(), ['id' => 'group_id']);
    }
}
