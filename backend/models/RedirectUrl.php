<?php

namespace backend\models;

use common\utils\FileUtils;
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
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new RedirectUrl();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'RedirectUrl';
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            $model->created_by = $username;
            $model->created_at = $now;
        
            $from_urls_arr = explode("\n", str_replace("\r", "", $model->from_urls));
            foreach ($from_urls_arr as &$item) {
                $item = trim($item);
            }
            $model->from_urls = json_encode($from_urls_arr);
            
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
                $log->object_class = 'RedirectUrl';
                $log->object_pk = $this->id;
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            $this->updated_by = $username;
            $this->updated_at = $now;
            
            $from_urls_arr = explode("\n", str_replace("\r", "", $this->from_urls));
            foreach ($from_urls_arr as &$item) {
                $item = trim($item);
            }
            $this->from_urls = json_encode($from_urls_arr);
            
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
            $log->object_class = 'RedirectUrl';
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
        return 'redirect_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_urls', 'to_url', 'created_by', 'created_at'], 'required', 'message' => '{attribute} không thể để trống'],
            [['from_urls'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_active', 'status'], 'integer'],
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
            'from_urls' => 'Các url cần chuyển hướng',
            'to_url' => 'Url đích',
            'created_by' => 'Người thêm',
            'created_at' => 'Thêm lúc',
            'updated_by' => 'Người cật nhật',
            'updated_at' => 'Cập nhật lúc',
            'is_active' => 'Kích hoạt',
            'status' => 'Trạng thái',
        ];
    }
}
