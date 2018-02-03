<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use Yii;
use yii\web\UploadedFile;
use frontend\models\UrlParam;

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
 * @property ProductCustomization[] $productCustomizations
 * @property ProductCustomizationTracking[] $productCustomizationTrackings
 * @property ProductImage[] $productImages
 * @property ProductRelated[] $productRelateds
 * @property ProductRelated[] $productRelateds0
 * @property ProductToTag[] $productToTags
 * @property PurchaseOrderDetail[] $purchaseOrderDetails
 */
class Product extends \common\models\Product
{
    
    /**
    * function ->getLink ()
    */
//    public $_link;
//    public function getLink ()
//    {
//        if ($this->_link === null) {
//            $this->_link = Yii::$app->params['frontend_url']
//                . Yii::$app->frontendUrlManager->createUrl(['product/index', 'slug' => $this->slug]);
//        }
//        return $this->_link;
//    }

    public $_link;
    public function getLink()
    {
        if ($this->_link == null) {
            if ($category = $this->category) {
                if ($parent_category = $category->parent) {
                    $this->_link = Yii::$app->params['frontend_url'] .
                        Yii::$app->frontendUrlManager->createUrl([
                        'product/index',
                        UrlParam::SLUG => $this->slug,
                        UrlParam::CATEGORY_SLUG => $category->slug,
                        UrlParam::PARENT_SLUG => $parent_category->slug
                    ], true);
                } else {
                    $this->_link = Yii::$app->params['frontend_url'] .
                        Yii::$app->frontendUrlManager->createUrl([
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

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new Product();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'Product';
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            $model->published_at = strtotime($model->published_at);
            $model->created_at = $now;
            $model->created_by = $username;
                

            $model->image_path = FileUtils::generatePath($now, Yii::$app->params['images_folder']);

            $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $model->image_path;
            
            if (!empty($data['product-image'])) {
                $copyResult = FileUtils::copyImage([
                    'imageName' => $model->image,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$image_resizes),
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $model->image = $copyResult['imageName'];
                }
            }
            if (!empty($data['product-banner'])) {
                $copyResult = FileUtils::copyImage([
                    'imageName' => $model->banner,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$banner_resizes),
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $model->banner = $copyResult['imageName'];
                }
            }
                    
            $model->long_description = FileUtils::copyContentImages([
                'content' => $model->long_description,
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
                    
            $model->details = FileUtils::copyContentImages([
                'content' => $model->details,
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
                    
            $model->content = FileUtils::copyContentImages([
                'content' => $model->content,
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
                $log->object_class = 'Product';
                $log->object_pk = $this->id;
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            $this->published_at = strtotime($this->published_at);
            $this->updated_at = $now;
            $this->updated_by = $username;
            if ($this->slug != $this->getOldAttribute('slug')) {
                $old_slugs_arr = json_decode($this->old_slugs, true);
                is_array($old_slugs_arr) or $old_slugs_arr = array();
                $old_slugs_arr[$now] = $this->getOldAttribute('slug');
                $this->old_slugs = json_encode($old_slugs_arr);
            }
                  
            if ($this->image_path == null || trim($this->image_path) == '' || !is_dir(Yii::$app->params['images_folder'] . $this->image_path)) {
                $this->image_path = FileUtils::generatePath($now, Yii::$app->params['images_folder']);
            }
            
            $targetFolder = Yii::$app->params['images_folder'] . $this->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $this->image_path;
            
            if (!empty($data['product-image'])) {
                $copyResult = FileUtils::updateImage([
                    'imageName' => $this->image,
                    'oldImageName' => $this->getOldAttribute('image'),
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$image_resizes),
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $this->image = $copyResult['imageName'];
                }
            }
            if (!empty($data['product-banner'])) {
                $copyResult = FileUtils::updateImage([
                    'imageName' => $this->banner,
                    'oldImageName' => $this->getOldAttribute('banner'),
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$banner_resizes),
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $this->banner = $copyResult['imageName'];
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
            $this->details = FileUtils::updateContentImages([
                'content' => $this->details,
                'oldContent' => $this->getOldAttribute('details'),
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
            $this->content = FileUtils::updateContentImages([
                'content' => $this->content,
                'oldContent' => $this->getOldAttribute('content'),
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
            $log->object_class = 'Product';
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
            if ($this->image_path != '') {
                $targetFolder = Yii::$app->params['images_folder'] . $this->image_path;
                $targetUrl = Yii::$app->params['images_url'] . $this->image_path;
            
                FileUtils::updateImage([
                    'imageName' => '',
                    'oldImageName' => $this->image,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$image_resizes),
                ]);
                
                FileUtils::updateImage([
                    'imageName' => '',
                    'oldImageName' => $this->banner,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$banner_resizes),
                ]);
                
                FileUtils::updateContentImages([
                    'content' => '',
                    'oldContent' => $this->long_description,
                    'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'toUrl' => $targetUrl,
                ]);
                
                FileUtils::updateContentImages([
                    'content' => '',
                    'oldContent' => $this->details,
                    'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'toUrl' => $targetUrl,
                ]);
                
                FileUtils::updateContentImages([
                    'content' => '',
                    'oldContent' => $this->content,
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
        return 'product';
    }

    /**
     * @vars
     */
    public $image_files;
    public $related_ids;
    public $attribute_ids;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'price', 'original_price', 'is_hot', 'is_active', 'status', 'sort_order', 'view_count', 'like_count', 'share_count', 'comment_count', 'available_quantity', 'order_quantity', 'sold_quantity', 'total_quantity', 'total_revenue', 'review_score', 'type'], 'integer'],
            [['name', 'slug', 'published_at', 'created_at', 'created_by'], 'required'],
            [['long_description', 'details', 'content'], 'string'],
            [['published_at', 'created_at', 'updated_at'], 'safe'],
            [['name', 'label', 'slug', 'code', 'created_by', 'updated_by', 'auth_alias', 'manufacturer', 'color', 'malterial', 'style', 'use_duration', 'manufacturing_date', 'size', 'weight', 'ingredient', 'model'], 'string', 'max' => 255],
            [['old_slugs'], 'string', 'max' => 2000],
            [['image', 'banner', 'image_path', 'description', 'page_title', 'h1', 'meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['image_files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 20],
            [['related_ids', 'attribute_ids'], 'each', 'rule' => ['integer']]
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
            'image_files' => 'Ảnh chi tiết',
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
    public function getProductCustomizations()
    {
        return $this->hasMany(ProductCustomization::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCustomizationTrackings()
    {
        return $this->hasMany(ProductCustomizationTracking::className(), ['product_id' => 'id']);
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
}
