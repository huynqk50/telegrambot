<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_attribute".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $name
 * @property string $label
 * @property integer $sort_order
 *
 * @property ProductAttributeGroup $group
 * @property ProductToAttribute[] $productToAttributes
 */
class ProductAttribute extends \common\models\ProductAttribute
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'name'], 'required'],
            [['group_id', 'sort_order'], 'integer'],
            [['name', 'label'], 'string', 'max' => 511],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductAttributeGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'name' => 'Name',
            'label' => 'Label',
            'sort_order' => 'Sort Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(ProductAttributeGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToAttributes()
    {
        return $this->hasMany(ProductToAttribute::className(), ['attribute_id' => 'id']);
    }
}
