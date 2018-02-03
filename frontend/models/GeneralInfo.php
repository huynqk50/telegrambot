<?php

namespace frontend\models;

use Yii;
use common\models\GeneralInfo as G2;
/**
 * This is the model class for table "general_info".
 *
 * @property integer $id
 * @property string $slug
 * @property string $old_slugs
 * @property integer $type
 * @property string $image_path
 * @property string $image
 * @property string $banner
 * @property integer $is_active
 * @property integer $created_at
 * @property string $created_by
 * @property integer $updated_at
 * @property string $updated_by
 * @property string $name
 * @property string $content
 * @property string $description
 * @property string $search_text
 * @property string $page_title
 * @property string $h1
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $ref_url
 */
class GeneralInfo extends G2
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'general_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'created_at', 'name', 'content'], 'required'],
            [['type', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['slug', 'created_by', 'updated_by', 'name', 'search_text'], 'string', 'max' => 255],
            [['old_slugs'], 'string', 'max' => 5000],
            [['image_path', 'image', 'banner', 'description', 'page_title', 'h1', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 511],
            [['ref_url'], 'string', 'max' => 512],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'old_slugs' => 'Old Slugs',
            'type' => 'Type',
            'image_path' => 'Image Path',
            'image' => 'Image',
            'banner' => 'Banner',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'name' => 'Name',
            'content' => 'Content',
            'description' => 'Description',
            'search_text' => 'Search Text',
            'page_title' => 'Page Title',
            'h1' => 'H1',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'ref_url' => 'Ref Url',
        ];
    }
}
