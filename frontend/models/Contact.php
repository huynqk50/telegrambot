<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone_number
 * @property string $address
 */
class Contact extends \common\models\Contact
{
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'phone_number'], 'required', 'on' => 'email-and-phone_number'],
            [['email'], 'required', 'on' => 'only-email'],
            [['name', 'email', 'message'], 'required', 'on' => 'full-info'],
            ['email', 'email'],
            [['created_at'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['name', 'address', 'email', 'phone_number', 'updated_by'], 'string', 'max' => 255],
            [['message'], 'string', 'max' => 2023],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Họ tên',
            'email' => 'Email',
            'phone_number' => 'Số điện thoại',
            'address' => 'Address',
            'message' => 'Nội dung',
            'verifyCode' => 'Mã xác thực',
        ];
    }
}
