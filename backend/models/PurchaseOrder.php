<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use yii\helpers\Html;
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

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new PurchaseOrder();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'PurchaseOrder';
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            $model->created_at = $now;
            if ($model->save()) {
                if ($log) {
                    $log->object_pk = $model->id;
                    $log->is_success = 1;
                    $log->save();
                }
                return $model;
            }
            Dump::errors($model->errors);
            return;
        }
        return false;
    }
    
    /**
    * function ->update2 ($data)
    */
    public function update2 ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;   
        if ($this->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Update';
                $log->object_class = 'PurchaseOrder';
                $log->object_pk = $this->id;
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            $this->updated_at = $now;
            $this->updated_by = $username;
            
            if ($this->save()) {
                if ($log) {
                    $log->is_success = 1;
                    $log->save();
                }
                return $this;
            }
        }
        return false;
    }
    
    /**
    * function ->delete ()
    */
    public function delete ()
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;    
        if ($log = new UserLog()) {
            $log->username = $username;
            $log->action = 'Delete';
            $log->object_class = 'PurchaseOrder';
            $log->object_pk = $this->id;
            $log->created_at = $now;
            $log->is_success = 0;
            $log->save();
        }
        if(parent::delete()) {
            if ($log) {
                $log->is_success = 1;
                $log->save();
            }
            return true;
        }
        return false;
    }
    
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
            [['code', 'status', 'created_at', 'customer_name', 'customer_email', 'customer_address'], 'required'],
            [['status', 'customer_id', 'shipping_fee', 'tax'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code', 'customer_name', 'customer_email', 'customer_phone_number', 'customer_city', 'updated_by', 'shipping_duration'], 'string', 'max' => 255],
            [['customer_address', 'customer_address_2'], 'string', 'max' => 511],
            [['customer_note', 'user_note'], 'string', 'max' => 2000],
            [['code'], 'unique']
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
            'customer_name' => 'Customer Name',
            'customer_email' => 'Customer Email',
            'customer_phone_number' => 'Customer Phone Number',
            'customer_address' => 'Customer Address',
            'customer_address_2' => 'Customer Address 2',
            'customer_city' => 'Customer City',
            'customer_note' => 'Customer Note',
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
