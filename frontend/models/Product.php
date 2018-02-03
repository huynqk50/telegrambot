<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $label
 * @property string $slug
 * @property string $code
 * @property string $old_slugs
 * @property integer $price
 * @property integer $original_price
 * @property string $image
 * @property string $banner
 * @property string $image_path
 * @property string $description
 * @property string $long_description
 * @property string $details
 * @property string $content
 * @property string $page_title
 * @property string $h1
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $is_hot
 * @property integer $is_active
 * @property integer $status
 * @property integer $sort_order
 * @property integer $view_count
 * @property integer $like_count
 * @property integer $share_count
 * @property integer $comment_count
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $auth_alias
 * @property integer $available_quantity
 * @property integer $order_quantity
 * @property integer $sold_quantity
 * @property integer $total_quantity
 * @property integer $total_revenue
 * @property integer $review_score
 * @property string $manufacturer
 * @property string $color
 * @property string $malterial
 * @property string $style
 * @property string $use_duration
 * @property string $manufacturing_date
 * @property string $size
 * @property string $weight
 * @property string $ingredient
 * @property string $model
 * @property integer $type
 *
 * @property ProductCategory $category
 * @property ProductImage[] $productImages
 * @property ProductToProductCategory[] $productToProductCategories
 * @property ProductCategory[] $productCategories
 * @property ProductToTag[] $productToTags
 * @property PurchaseOrderDetail[] $purchaseOrderDetails
 */
class Product extends \common\models\Product
{
    public $_link;
    public function getLink()
    {
        if ($this->_link == null) {
            if ($category = $this->findCategory()) {
                if ($parent_category = $category->findParent()) {
                    $this->_link = \yii\helpers\Url::to([
                        'product/index',
                        UrlParam::SLUG => $this->slug,
                        UrlParam::CATEGORY_SLUG => $category->slug,
                        UrlParam::PARENT_SLUG => $parent_category->slug
                    ], true);
                } else {
                    $this->_link = \yii\helpers\Url::to([
                        'product/index',
                        UrlParam::SLUG => $this->slug,
                        UrlParam::CATEGORY_SLUG => $category->slug
                    ], true);
                }
            } else {
                $this->_link = '';
            }
        }
        
        return $this->_link;
    }

    public function findCategory()
    {
        return ProductCategory::findOneById($this->category_id);
    }

    public static function findOneBySlug($slug)
    {
        return self::find()->where(['slug' => $slug])->oneActive();
    }
    
    public function hasDiscount()
    {
        return $this->price < $this->original_price;
    }

    public function discountPercent($decimals = 0)
    {
        $this->original_price || $this->original_price = 0;
        return ($this->original_price > $this->price)
            ? number_format(100 * ($this->original_price - $this->price) / $this->original_price, $decimals, ',', '.')
            : 0;
    }

    public function isStockAvailable()
    {
        return $this->available_quantity > 0;
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'price', 'original_price', 'is_hot', 'is_active', 'status', 'sort_order', 'view_count', 'like_count', 'share_count', 'comment_count', 'published_at', 'created_at', 'updated_at', 'available_quantity', 'order_quantity', 'sold_quantity', 'total_quantity', 'total_revenue', 'review_score', 'type'], 'integer'],
            [['long_description', 'details', 'content'], 'string'],
            [['name', 'slug', 'published_at', 'created_at', 'created_by'], 'required'],
            [['name', 'label', 'slug', 'code', 'created_by', 'updated_by', 'auth_alias', 'manufacturer', 'color', 'malterial', 'style', 'use_duration', 'manufacturing_date', 'size', 'weight', 'ingredient', 'model'], 'string', 'max' => 255],
            [['old_slugs'], 'string', 'max' => 2000],
            [['image', 'banner', 'image_path', 'description', 'page_title', 'h1', 'meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'code' => 'Code',
            'old_slugs' => 'Old Slugs',
            'price' => 'Price',
            'original_price' => 'Original Price',
            'image' => 'Image',
            'banner' => 'Banner',
            'image_path' => 'Image Path',
            'description' => 'Description',
            'long_description' => 'Long Description',
            'details' => 'Details',
            'content' => 'Content',
            'page_title' => 'Page Title',
            'h1' => 'H1',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'is_hot' => 'Is Hot',
            'is_active' => 'Is Active',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
            'view_count' => 'View Count',
            'like_count' => 'Like Count',
            'share_count' => 'Share Count',
            'comment_count' => 'Comment Count',
            'published_at' => 'Published At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'auth_alias' => 'Auth Alias',
            'available_quantity' => 'Available Quantity',
            'order_quantity' => 'Order Quantity',
            'sold_quantity' => 'Sold Quantity',
            'total_quantity' => 'Total Quantity',
            'total_revenue' => 'Total Revenue',
            'review_score' => 'Review Score',
            'manufacturer' => 'Manufacturer',
            'color' => 'Color',
            'malterial' => 'Malterial',
            'style' => 'Style',
            'use_duration' => 'Use Duration',
            'manufacturing_date' => 'Manufacturing Date',
            'size' => 'Size',
            'weight' => 'Weight',
            'ingredient' => 'Ingredient',
            'model' => 'Model',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToProductCategories()
    {
        return $this->hasMany(ProductToProductCategory::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::className(), ['id' => 'product_category_id'])->viaTable('product_to_product_category', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToTags()
    {
        return $this->hasMany(ProductToTag::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCustomizations()
    {
        return $this->hasMany(ProductCustomization::className(), ['product_id' => 'id']);
    }

    public function getProductRelateds()
    {
        return $this->hasMany(ProductRelated::className(), ['product_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductRelateds0()
    {
        return $this->hasMany(ProductRelated::className(), ['related_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToAttributes()
    {
        return $this->hasMany(ProductToAttribute::className(), ['product_id' => 'id']);
    }

    public function getProductTrackings()
    {
        return $this->hasMany(ProductTracking::className(), ['product_id' => 'id']);
    }

    public function getProductAttributes()
    {
        return $this->hasMany(ProductAttribute::className(), ['id' => 'attribute_id'])->via('productToAttributes');
    }

    public function getRelatedProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'related_id'])->via('productRelateds');
    }
}
