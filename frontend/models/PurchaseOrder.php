<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "purchase_order".
 *
 * @property integer $id
 * @property string $code
 * @property integer $status
 * @property integer $created_at
 * @property integer $customer_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string $customer_phone_number
 * @property string $customer_address
 * @property string $customer_address_2
 * @property string $customer_city
 * @property string $customer_note
 * @property string $user_note
 * @property integer $updated_at
 * @property string $updated_by
 * @property integer $shipping_fee
 * @property string $shipping_duration
 * @property integer $tax
 *
 * @property Customer $customer
 * @property PurchaseOrderDetail[] $purchaseOrderDetails
 */
class PurchaseOrder extends \common\models\PurchaseOrder
{
    public $handle_error;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'status', 'created_at', 'customer_name', 'customer_email', 'customer_address', 'customer_phone_number'], 'required'],
            [['status', 'created_at', 'customer_id', 'updated_at', 'shipping_fee', 'tax'], 'integer'],
            [['code', 'customer_name', 'customer_email', 'customer_phone_number', 'customer_city', 'updated_by', 'shipping_duration'], 'string', 'max' => 255],
            [['customer_address', 'customer_address_2'], 'string', 'max' => 511],
            [['customer_note', 'user_note'], 'string', 'max' => 2000],
            [['code'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'status' => 'Status',
            'created_at' => 'Created At',
            'customer_id' => 'Customer ID',
            'customer_name' => 'Họ và tên',
            'customer_email' => 'Email',
            'customer_phone_number' => 'Số điện thoại',
            'customer_address' => 'Địa chỉ giao hàng',
            'customer_address_2' => 'Địa chỉ giao hàng 2',
            'customer_city' => 'Customer City',
            'customer_note' => 'Ghi chú',
            'user_note' => 'User Note',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'shipping_fee' => 'Shipping Fee',
            'shipping_duration' => 'Shipping Duration',
            'tax' => 'Tax',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::className(), ['purchase_order_id' => 'id']);
    }
}
