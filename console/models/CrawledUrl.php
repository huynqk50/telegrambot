<?php

namespace console\models;

use common\utils\FileUtils;
use common\utils\Dump;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "crawled_url".
 *
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $keywords
 * @property string $img_src
 * @property integer $time
 * @property string $host
 * @property string $content
 * @property string $description
 * @property integer $created_at
 */
class CrawledUrl extends \common\models\MyActiveRecord
{

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new CrawledUrl();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'CrawledUrl';
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
                $log->object_class = 'CrawledUrl';
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
            $log->object_class = 'CrawledUrl';
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
        return 'crawled_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['url', 'title', 'keywords', 'img_src'], 'string', 'max' => 511],
            [['host'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1023]
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
            'title' => 'Title',
            'keywords' => 'Keywords',
            'img_src' => 'Img Src',
            'time' => 'Time',
            'host' => 'Host',
            'content' => 'Content',
            'description' => 'Description',
        ];
    }
}
