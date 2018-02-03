<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "redirect_url".
 *
 * @property integer $id
 * @property string $from_urls
 * @property string $to_url
 * @property string $created_by
 * @property integer $created_at
 * @property string $updated_by
 * @property integer $updated_at
 * @property integer $is_active
 * @property integer $status
 */
class RedirectUrl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'redirect_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_urls', 'to_url', 'created_by', 'created_at'], 'required'],
            [['from_urls'], 'string'],
            [['created_at', 'updated_at', 'is_active', 'status'], 'integer'],
            [['to_url'], 'string', 'max' => 511],
            [['created_by', 'updated_by'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_urls' => 'From Urls',
            'to_url' => 'To Url',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'is_active' => 'Is Active',
            'status' => 'Status',
        ];
    }
}
