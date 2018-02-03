<?php

namespace frontend\models;

use backend\models\ArticleToArticleCategory;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property string $slug
 * @property string $old_slugs
 * @property integer $parent_id
 * @property string $description
 * @property string $long_description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $h1
 * @property string $page_title
 * @property string $image
 * @property string $banner
 * @property string $image_path
 * @property integer $status
 * @property integer $is_hot
 * @property integer $sort_order
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property integer $is_active
 * @property integer $type
 *
 * @property Article[] $articles
 * @property ArticleCategory $parent
 * @property ArticleCategory[] $articleCategories
 * @property ArticleToArticleCategory[] $articleToArticleCategories
 * @property Article[] $articles0
 */
class ArticleCategory extends \common\models\ArticleCategory
{
    public $_link;
    public function getLink()
    {
        if ($this->_link == null) {
            if ($parent = $this->findParent()) {
                $this->_link = Url::to([
                        'article/category',
                        UrlParam::SLUG => $this->slug,
                        UrlParam::PARENT_SLUG => $parent->slug
                    ], true);
            } else {
                $this->_link = Url::to([
                        'article/category',
                        UrlParam::SLUG => $this->slug
                    ], true);
            }
        }
        
        return $this->_link;
    }
    
    private static $_indexData;
    
    public static function indexData()
    {
        if (self::$_indexData == null) {
//            self::$_indexData = self::find()->indexBy('id')
//                    ->orderBy('sort_order asc')->allActive();
            self::$_indexData = self::find()->where(['id' => 262])->indexBy('id')
                    ->orderBy('sort_order asc')->allActive();
        }
        
        return self::$_indexData;
    }
    
    public function getAllArticles()
    {
        $query = Article::find();
        $query->where([
                'in', 
                'category_id',
                array_merge(
                    [$this->id],
                    ArrayHelper::getColumn($this->findChildren(), 'id')
                )
            ]);
        $query->multiple = true;
        return $query;
    }

    public static function findOneBySlug($slug)
    {
        foreach (self::indexData() as $item) {
            if ($item->slug == $slug && !$item->findParent()) {
                return $item;
            }
        }

        return null;
    }

    public static function findOneBySlugAndParentSlug($slug, $parent_slug)
    {
        foreach (self::indexData() as $item) {
            if ($parent = $item->findParent()) {
                if ($item->slug == $slug && $parent->slug == $parent_slug) {
                    return $item;
                }
            }
        }

        return null;
    }
    
    public static function findOneByType($type)
    {
        $data = static::indexData();
        foreach ($data as $item) {
            if ($item->type == $type) {
                return $item;
            }
        }
        
        return null;
    }

    public static function findAllByTypes($types)
    {
        if (!$types) return [];
        $result = [];
        $data = static::indexData();
        foreach ($data as $item) {
            if (in_array($item->type, $types)) {
                $result[] = $item;
            }
        }

        return $result;
    }



    public static function findOneById($id)
    {
        $data = static::indexData();
        return isset($data[$id]) ? $data[$id] : null;
    }

    public $_parent = 1;
    public function findParent()
    {
        if ($this->parent_id === null) {
            return false;
        }
        
        if ($this->_parent === 1) {
            $this->_parent = self::findOneById($this->parent_id);
        }
        
        return $this->_parent;
    }
    
    public $_children = 1;
    public function findChildren()
    {
        if ($this->_children === 1) {
            $this->_children = [];
            $items = static::indexData();
            foreach ($items as $item) {
                if ($item->parent_id == $this->id) {
                    $this->_children[] = $item;
                }
            }
        }
        
        return $this->_children;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'status', 'is_hot', 'sort_order', 'created_at', 'updated_at', 'is_active', 'type'], 'integer'],
            [['long_description'], 'string'],
            [['created_at', 'created_by'], 'required'],
            [['name', 'label', 'slug', 'created_by', 'updated_by'], 'string', 'max' => 255],
            [['old_slugs'], 'string', 'max' => 2000],
            [['description', 'meta_title', 'meta_description', 'meta_keywords', 'h1', 'page_title', 'image', 'banner', 'image_path'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'label' => 'Label',
            'slug' => 'Slug',
            'old_slugs' => 'Old Slugs',
            'parent_id' => 'Parent ID',
            'description' => 'Description',
            'long_description' => 'Long Description',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'h1' => 'H1',
            'page_title' => 'Page Title',
            'image' => 'Image',
            'banner' => 'Banner',
            'image_path' => 'Image Path',
            'status' => 'Status',
            'is_hot' => 'Is Hot',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'is_active' => 'Is Active',
            'type' => 'Type',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getArticleToArticleCategories()
    {
        return $this->hasMany(ArticleToArticleCategory::className(), ['article_category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getArticles0()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])->viaTable('article_to_article_category', ['article_category_id' => 'id']);
    }
}
