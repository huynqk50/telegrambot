<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use Yii;

/**
 * This is the model class for table "product_customization_to_option".
 *
 * @property integer $id
 * @property integer $customization_id
 * @property integer $option_id
 *
 * @property ProductCustomization $customization
 * @property ProductOption $option
 */
class ProductCustomizationToOption extends \yii\db\ActiveRecord
{

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new ProductCustomizationToOption();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'ProductCustomizationToOption';
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
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
                $log->object_class = 'ProductCustomizationToOption';
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
            $log->object_class = 'ProductCustomizationToOption';
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
        return 'product_customization_to_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customization_id', 'option_id'], 'required'],
            [['customization_id', 'option_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customization_id' => 'Customization ID',
            'option_id' => 'Option ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomization()
    {
        return $this->hasOne(ProductCustomization::className(), ['id' => 'customization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(ProductOption::className(), ['id' => 'option_id']);
    }
}
