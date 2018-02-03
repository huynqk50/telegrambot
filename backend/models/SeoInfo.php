<?php

namespace backend\models;

use common\utils\FileUtils;
use Yii;

/**
 * This is the model class for table "seo_info".
 *
 * @property integer $id
 * @property string $url
 * @property integer $type
 * @property integer $is_active
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $long_description
 * @property string $h1
 * @property string $image
 * @property string $image_path
 * @property integer $created_at
 * @property string $created_by
 * @property integer $updated_at
 * @property string $updated_by
 */
class SeoInfo extends \yii\db\ActiveRecord
{
        
    /**
    * function ->getImage ($suffix, $refresh)
    */
    public $_image;
    public function getImage ($suffix = null, $refresh = false)
    {
        if ($this->_image === null || $refresh == true) {
            $this->_image = FileUtils::getImage([
               'imageName' => $this->image,
               'imagePath' => $this->image_path,
               'imagesFolder' => Yii::$app->params['images_folder'],
               'imagesUrl' => Yii::$app->params['images_url'],
               'suffix' => $suffix,
               'defaultImage' => Yii::$app->params['default_image']
           ]);
        }
        return $this->_image;
    }
    
    /**
    * function ->getLink ()
    */
    public $_link;
    public function getLink ()
    {
        if ($this->_link === null) {
            $_link = '';
            if (preg_match("/(http:|https:)/i", $this->url)) {
                $_link = $this->url;
            } else {
                $_link = Yii::$app->params['frontend_url'] . '/' . trim($this->url, '/');
            }
            $this->_link = $_link;
        }
        return $this->_link;
    }

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new SeoInfo();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'SeoInfo';
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            $model->created_at = $now;
            $model->created_by = $username;
                
            $model->image_path = FileUtils::generatePath($now, Yii::$app->params['images_folder']);
               
            $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $model->image_path;
            
            if (!empty($data['seoinfo-image'])) {
                $copyResult = FileUtils::copyImage([
                    'imageName' => $model->image,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $model->image = $copyResult['imageName'];
                }
            }
                    
            $model->long_description = FileUtils::copyContentImages([
                'content' => $model->long_description,
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
        
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
                $log->object_class = 'SeoInfo';
                $log->object_pk = $this->id;
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            $this->updated_at = $now;
            $this->updated_by = $username;
                  
            if ($this->image_path == null || trim($this->image_path) == '' || !is_dir(Yii::$app->params['images_folder'] . $this->image_path)) {
                $this->image_path = FileUtils::generatePath($now, Yii::$app->params['images_folder']);
            }
           
            $targetFolder = Yii::$app->params['images_folder'] . $this->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $this->image_path;
            
            if (!empty($data['seoinfo-image'])) {
                $copyResult = FileUtils::updateImage([
                    'imageName' => $this->image,
                    'oldImageName' => $this->getOldAttribute('image'),
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $this->image = $copyResult['imageName'];
                }
            }
            $this->long_description = FileUtils::updateContentImages([
                'content' => $this->long_description,
                'oldContent' => $this->getOldAttribute('long_description'),
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
            
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
            $log->object_class = 'SeoInfo';
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
            
            if ($this->image_path != '') {
                $targetFolder = Yii::$app->params['images_folder'] . $this->image_path;
                $targetUrl = Yii::$app->params['images_url'] . $this->image_path;

                FileUtils::updateImage([
                    'imageName' => '',
                    'oldImageName' => $this->image,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                ]);

                FileUtils::updateContentImages([
                    'content' => '',
                    'oldContent' => $this->long_description,
                    'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'toUrl' => $targetUrl,
                ]);

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
        return 'seo_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'page_title', 'meta_title', 'meta_keywords', 'meta_description', 'h1', 'created_at', 'created_by'], 'required', 'message' => '{attribute} không thể để trống'],
            [['type', 'is_active'], 'integer', 'message' => '{attribute} phải là số tự nhiên'],
            [['url'], 'unique', 'message' => '{attribute} bị trùng lặp'],
            [['long_description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['url', 'page_title', 'meta_title', 'meta_keywords', 'meta_description', 'h1', 'image', 'image_path'], 'string', 'max' => 511],
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
            'url' => 'Url',
            'type' => 'Loại',
            'is_active' => 'Kích hoạt',
            'page_title' => 'Tiêu đề trang',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'long_description' => 'Mô tả chi tiết',
            'h1' => 'H1',
            'image' => 'Ảnh đại diện',
            'image_path' => 'Đường dẫn ảnh',
            'created_at' => 'Thêm mới lúc',
            'created_by' => 'Thêm bởi',
            'updated_at' => 'Cập nhật lúc',
            'updated_by' => 'Cập nhật bởi',
        ];
    }
}
