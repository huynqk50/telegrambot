<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $country
 * @property string $hotline
 * @property string $email
 * @property integer $sort_order
 */
class Store extends \common\models\Store
{
    private static $_indexData;
    
    public static function indexData()
    {
        if (self::$_indexData == null) {
            self::$_indexData = self::find()->indexBy('id')
                    ->orderBy('sort_order asc')->all();
        }
        
        return self::$_indexData;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address'], 'required'],
            [['sort_order'], 'integer'],
            [['name', 'province', 'city', 'district', 'country', 'hotline', 'email'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 2000],
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
            'address' => 'Address',
            'province' => 'Province',
            'city' => 'City',
            'district' => 'District',
            'country' => 'Country',
            'hotline' => 'Hotline',
            'email' => 'Email',
            'sort_order' => 'Sort Order',
        ];
    }
}
