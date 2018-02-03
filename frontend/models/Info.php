<?php

namespace frontend\models;

use common\models\Info as CommonInfo;
use yii\helpers\Url;

/**
 * This is the model class for table "info".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property string $slug
 * @property integer $is_active
 * @property integer $status
 * @property string $page_title
 * @property string $h1
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $long_description
 * @property string $description
 * @property string $content
 * @property string $image
 * @property string $image_path
 * @property string $old_slugs
 * @property integer $created_at
 * @property string $created_by
 * @property integer $updated_at
 * @property string $updated_by
 */
class Info extends CommonInfo
{
    
    private static $_indexData;
    
    public static function indexData()
    {
        if (self::$_indexData == null) {
            self::$_indexData = self::find()->indexBy('id')->allActive();
        }
        
        return self::$_indexData;
    }
    
    public static function findOneByType($type)
    {
        $data = self::indexData();
        foreach ($data as $item) {
            if ($item->type == $type) {
                return $item;
            }
        }
        return null;
    }
    
    public static function findAllByTypes($types)
    {
        $result = [];
        $data = self::indexData();
        foreach ($data as $item) {
            if (in_array($item->type, $types)) {
                $result[] = $item;
            }
        }
        return $result;
    }
    
    public static function findOneBySlug($slug)
    {
        return self::find()->where(['slug' => $slug])->oneActive();
    }
    
    public function getLink()
    {
        return Url::to(['info/index', UrlParam::SLUG => $this->slug], true);
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'slug', 'content', 'created_at', 'created_by'], 'required'],
            [['type', 'is_active', 'status', 'created_at', 'updated_at'], 'integer'],
            [['long_description', 'content'], 'string'],
            [['name', 'slug', 'page_title', 'h1', 'meta_title', 'meta_description', 'meta_keywords', 'image', 'image_path', 'created_by', 'updated_by'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 511],
            [['old_slugs'], 'string', 'max' => 2000],
            [['slug', 'is_active'], 'unique', 'targetAttribute' => ['slug', 'is_active'], 'message' => 'The combination of Slug and Is Active has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'slug' => 'Slug',
            'is_active' => 'Is Active',
            'status' => 'Status',
            'page_title' => 'Page Title',
            'h1' => 'H1',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'long_description' => 'Long Description',
            'description' => 'Description',
            'content' => 'Content',
            'image' => 'Image',
            'image_path' => 'Image Path',
            'old_slugs' => 'Old Slugs',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
