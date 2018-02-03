<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "product_customization_to_image".
 *
 * @property integer $id
 * @property integer $customization_id
 * @property integer $image_id
 *
 * @property ProductCustomization $customization
 * @property ProductImage $image
 */
class ProductCustomizationToImage extends \yii\db\ActiveRecord
{

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new ProductCustomizationToImage();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'ProductCustomizationToImage';
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
                $log->object_class = 'ProductCustomizationToImage';
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
            $log->object_class = 'ProductCustomizationToImage';
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
        return 'product_customization_to_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customization_id', 'image_id'], 'required'],
            [['customization_id', 'image_id'], 'integer']
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
            'image_id' => 'Image ID',
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
    public function getImage()
    {
        return $this->hasOne(ProductImage::className(), ['id' => 'image_id']);
    }
}
