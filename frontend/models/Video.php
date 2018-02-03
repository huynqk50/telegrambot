<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $label
 * @property string $slug
 * @property string $old_slugs
 * @property string $description
 * @property string $image
 * @property string $image_path
 * @property string $page_title
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $h1
 * @property string $long_description
 * @property string $source
 * @property integer $view_count
 * @property integer $like_count
 * @property integer $comment_count
 * @property integer $share_count
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property integer $published_at
 * @property string $auth_alias
 * @property integer $is_hot
 * @property integer $is_active
 * @property integer $sort_order
 * @property integer $status
 * @property integer $type
 *
 * @property VideoRelated[] $videoRelateds
 * @property VideoRelated[] $videoRelateds0
 */
class Video extends \common\models\Video
{
//    private static $_indexData;
//
//    public static function indexData()
//    {
//        if (self::$_indexData == null) {
//            self::$_indexData = self::find()->indexBy('id')
//                ->orderBy('sort_order asc')->allActive();
//        }
//
//        return self::$_indexData;
//    }
//
//    public static function findOneBySlug($slug)
//    {
//        $data = static::indexData();
//        foreach ($data as $item) {
//            if ($item->slug == $slug) {
//                return $item;
//            }
//        }
//
//        return null;
//    }

    public $_link;
    public function getLink()
    {
        if ($this->_link == null) {
            $this->_link = Url::to([
                'video/index',
                UrlParam::SLUG => $this->slug
            ], true);
        }

        return $this->_link;
    }

    public static function findOneBySlug($slug)
    {
        return self::find()->where(['slug' => $slug])->oneActive();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'view_count', 'like_count', 'comment_count', 'share_count', 'created_at', 'updated_at', 'published_at', 'is_hot', 'is_active', 'sort_order', 'status', 'type'], 'integer'],
            [['name', 'slug', 'created_at', 'created_by'], 'required'],
            [['long_description'], 'string'],
            [['name', 'label', 'slug', 'created_by', 'updated_by', 'auth_alias'], 'string', 'max' => 255],
            [['old_slugs'], 'string', 'max' => 2000],
            [['description', 'image', 'image_path', 'page_title', 'meta_title', 'meta_keywords', 'meta_description', 'h1'], 'string', 'max' => 511],
            [['source'], 'string', 'max' => 1023],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'label' => 'Label',
            'slug' => 'Slug',
            'old_slugs' => 'Old Slugs',
            'description' => 'Description',
            'image' => 'Image',
            'image_path' => 'Image Path',
            'page_title' => 'Page Title',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'h1' => 'H1',
            'long_description' => 'Long Description',
            'source' => 'Source',
            'view_count' => 'View Count',
            'like_count' => 'Like Count',
            'comment_count' => 'Comment Count',
            'share_count' => 'Share Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'published_at' => 'Published At',
            'auth_alias' => 'Auth Alias',
            'is_hot' => 'Is Hot',
            'is_active' => 'Is Active',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoRelateds()
    {
        return $this->hasMany(VideoRelated::className(), ['video_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoRelateds0()
    {
        return $this->hasMany(VideoRelated::className(), ['related_id' => 'id']);
    }

    public function getRelatedVideos()
    {
        return $this->hasMany(Video::className(), ['id' => 'related_id'])->via('videoRelateds');
    }
}
