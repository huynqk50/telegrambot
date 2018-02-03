<?php

namespace frontend\models;

use backend\models\ProductToProductCategory;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "product_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property string $slug
 * @property string $old_slugs
 * @property integer $parent_id
 * @property string $description
 * @property string $long_description
 * @property string $page_title
 * @property string $h1
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $image
 * @property string $banner
 * @property string $image_path
 * @property integer $is_hot
 * @property integer $is_active
 * @property integer $status
 * @property integer $sort_order
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property integer $type
 *
 * @property Product[] $products
 * @property ProductCategory $parent
 * @property ProductCategory[] $productCategories
 * @property ProductToProductCategory[] $productToProductCategories
 * @property Product[] $products0
 * @property ProductToTag[] $productToTags
 */
class ProductCategory extends \common\models\ProductCategory
{
    public $_link;
    public function getLink()
    {
        if ($this->_link == null) {
            if ($parent = $this->findParent()) {
                $this->_link = Url::to([
                    'product/category',
                    UrlParam::SLUG => $this->slug,
                    UrlParam::PARENT_SLUG => $parent->slug
                ], true);
            } else {
                $this->_link = Url::to([
                        'product/category',
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
            self::$_indexData = self::find()->indexBy('id')->orderBy('sort_order asc')->allActive();
        }
        
        return self::$_indexData;
    }
    
    public function getAllProducts()
    {
        $query = Product::find();
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
        $data = static::indexData();
        foreach ($data as $item) {
            if ($item->slug == $slug) {
                return $item;
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
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'is_hot', 'is_active', 'status', 'sort_order', 'created_at', 'updated_at', 'type'], 'integer'],
            [['long_description'], 'string'],
            [['created_at', 'created_by'], 'required'],
            [['name', 'label', 'slug', 'created_by', 'updated_by'], 'string', 'max' => 255],
            [['old_slugs'], 'string', 'max' => 2000],
            [['description', 'page_title', 'h1', 'meta_title', 'meta_description', 'meta_keywords', 'image', 'banner', 'image_path'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'page_title' => 'Page Title',
            'h1' => 'H1',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'image' => 'Image',
            'banner' => 'Banner',
            'image_path' => 'Image Path',
            'is_hot' => 'Is Hot',
            'is_active' => 'Is Active',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'type' => 'Type',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductToProductCategories()
    {
        return $this->hasMany(ProductToProductCategory::className(), ['product_category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProducts0()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('product_to_product_category', ['product_category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductToTags()
    {
        return $this->hasMany(ProductToTag::className(), ['product_category_id' => 'id']);
    }
}
