<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use Yii;

/**
 * This is the model class for table "product_customization".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @property string $label
 * @property integer $review_score
 * @property integer $order_quantity
 * @property integer $sold_quantity
 * @property integer $available_quantity
 * @property integer $total_quantity
 * @property integer $price
 * @property integer $original_price
 * @property integer $total_revenue
 * @property integer $sort_order
 *
 * @property Product $product
 * @property ProductCustomizationToOption[] $productCustomizationToOptions
 * @property ProductImage[] $productImages
 * @property ProductTracking[] $productTrackings
 * @property PurchaseOrderDetail[] $purchaseOrderDetails
 */
class ProductCustomization extends \common\models\ProductCustomization
{

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new ProductCustomization();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'ProductCustomization';
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
                $log->object_class = 'ProductCustomization';
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
                return true;
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
            $log->object_class = 'ProductCustomization';
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
     * Integer
     */
    public $option_ids;
    public $image_ids;

    /**
     * File
     */
    public $image_files;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_customization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'name', 'option_ids'], 'required'],
            [['option_ids', 'image_ids'], 'each', 'rule' => ['integer']],
            [['product_id', 'review_score', 'order_quantity', 'sold_quantity', 'available_quantity', 'total_quantity', 'price', 'original_price', 'total_revenue', 'sort_order'], 'integer'],
            [['image_files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 20],
            [['name', 'label'], 'string', 'max' => 511]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
            'label' => 'Label',
            'review_score' => 'Review Score',
            'order_quantity' => 'Order Quantity',
            'sold_quantity' => 'Sold Quantity',
            'available_quantity' => 'Available Quantity',
            'total_quantity' => 'Total Quantity',
            'price' => 'Price',
            'original_price' => 'Original Price',
            'total_revenue' => 'Total Revenue',
            'sort_order' => 'Sort Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCustomizationToImages()
    {
        return $this->hasMany(ProductCustomizationToImage::className(), ['customization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['id' => 'image_id'])->via('productCustomizationToImages');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCustomizationToOptions()
    {
        return $this->hasMany(ProductCustomizationToOption::className(), ['customization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductOptions()
    {
        return $this->hasMany(ProductOption::className(), ['id' => 'option_id'])->via('productCustomizationToOptions');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTrackings()
    {
        return $this->hasMany(ProductTracking::className(), ['customization_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::className(), ['product_customization_id' => 'id']);
    }
}
