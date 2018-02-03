<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_option_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property integer $sort_order
 *
 * @property ProductOption[] $productOptions
 */
class ProductOptionGroup extends \common\models\ProductOptionGroup
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_option_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort_order'], 'integer'],
            [['name', 'label'], 'string', 'max' => 511],
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
            'sort_order' => 'Sort Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductOptions()
    {
        return $this->hasMany(ProductOption::className(), ['group_id' => 'id']);
    }
}
