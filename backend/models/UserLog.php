<?php

namespace backend\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_log".
 *
 * @property integer $id
 * @property string $username
 * @property string $action
 * @property integer $created_at
 * @property integer $is_success
 * @property string $object_class
 * @property integer $object_pk
 *
 * @property User $username0
 */
class UserLog extends ActiveRecord
{

    public function save($runValidation = true, $attributeNames = null) {
        if (parent::save($runValidation, $attributeNames)) {
//            if ($this->is_success == 1) {
                Yii::$app->cache->flush();
//            }
        }
        return;
    }
    
    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new UserLog();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'UserLog';
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
            $model->getErrors();
            return $model;
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
                $log->object_class = 'UserLog';
                $log->object_pk = $this->id;
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            
            if ($this->save()) {
                if ($log) {
                    $log->is_success = 1;
                    $log->save();
                }
                return true;
            }
            return false;
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
        $model = $this;
        if ($log = new UserLog()) {
            $log->username = $username;
            $log->action = 'Delete';
            $log->object_class = 'UserLog';
            $log->object_pk = $model->id;
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
        return 'user_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'required'],
            [['created_at'], 'safe'],
            [['is_success', 'object_pk'], 'integer'],
            [['username', 'action', 'object_class'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'action' => 'Action',
            'created_at' => 'Created At',
            'is_success' => 'Is Success',
            'object_class' => 'Object Class',
            'object_pk' => 'Object Pk',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUsername0()
    {
        return $this->hasOne(User::className(), ['username' => 'username']);
    }
}
