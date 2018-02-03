<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $label
 * @property string $slug
 * @property string $old_slugs
 * @property string $content
 * @property string $description
 * @property string $image
 * @property string $image_path
 * @property string $page_title
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $h1
 * @property integer $view_count
 * @property integer $like_count
 * @property integer $comment_count
 * @property integer $share_count
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $auth_alias
 * @property integer $is_hot
 * @property integer $sort_order
 * @property integer $status
 * @property string $long_description
 * @property integer $published_at
 * @property integer $is_active
 * @property integer $type
 *
 * @property ArticleCategory $category
 * @property ArticleToArticleCategory[] $articleToArticleCategories
 * @property ArticleCategory[] $articleCategories
 * @property ArticleToTag[] $articleToTags
 * @property Tag[] $tags
 */
class Article extends \common\models\Article
{
    public $_link;
    public function getLink()
    {
        $category = $this->findCategory();
        Yii::error($category);
        if ($this->_link == null) {
            if ($category = $this->findCategory()) {
                if ($parent_category = $category->findParent()) {
                    $this->_link = \yii\helpers\Url::to([
                            'article/index',
                            UrlParam::SLUG => $this->slug,
                            UrlParam::CATEGORY_SLUG => $category->slug,
                            UrlParam::PARENT_SLUG => $parent_category->slug
                        ], true);
                } else {
                    $this->_link = \yii\helpers\Url::to([
                            'article/index',
                            UrlParam::SLUG => $this->slug,
                            UrlParam::CATEGORY_SLUG => $category->slug
                        ], true);
                }
            } else {
                $this->_link = \yii\helpers\Url::to([
                    'article/index',
                    UrlParam::SLUG => $this->slug,
                ], true);
            }
        }

        return $this->_link;
    }

    public function findCategory()
    {
        return ArticleCategory::findOneById($this->category_id);
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
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'view_count', 'like_count', 'comment_count', 'share_count', 'created_at', 'updated_at', 'is_hot', 'sort_order', 'status', 'published_at', 'is_active', 'type'], 'integer'],
            [['content', 'long_description'], 'string'],
            [['created_at', 'created_by', 'published_at'], 'required'],
            [['name', 'label', 'slug', 'created_by', 'updated_by', 'auth_alias'], 'string', 'max' => 255],
            [['old_slugs'], 'string', 'max' => 2000],
            [['description', 'image', 'image_path', 'page_title', 'meta_title', 'meta_keywords', 'meta_description', 'h1'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'content' => 'Content',
            'description' => 'Description',
            'image' => 'Image',
            'image_path' => 'Image Path',
            'page_title' => 'Page Title',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'h1' => 'H1',
            'view_count' => 'View Count',
            'like_count' => 'Like Count',
            'comment_count' => 'Comment Count',
            'share_count' => 'Share Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'auth_alias' => 'Auth Alias',
            'is_hot' => 'Is Hot',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'long_description' => 'Long Description',
            'published_at' => 'Published At',
            'is_active' => 'Is Active',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleRelateds()
    {
        return $this->hasMany(ArticleRelated::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleRelateds0()
    {
        return $this->hasMany(ArticleRelated::className(), ['related_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleToTags()
    {
        return $this->hasMany(ArticleToTag::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('article_to_tag', ['article_id' => 'id']);
    }

    public function getRelatedArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'related_id'])->via('articleRelateds');
    }
}
