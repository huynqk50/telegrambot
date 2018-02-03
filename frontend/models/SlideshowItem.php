<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "slideshow_item".
 *
 * @property integer $id
 * @property string $image
 * @property string $image_path
 * @property string $link
 * @property string $caption
 * @property integer $sort_order
 * @property integer $is_active
 * @property integer $created_at
 * @property string $created_by
 * @property integer $updated_at
 * @property string $updated_by
 * @property integer $type
 */
class SlideshowItem extends \common\models\SlideshowItem
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slideshow_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image', 'image_path', 'is_active', 'created_at'], 'required'],
            [['sort_order', 'is_active', 'created_at', 'updated_at', 'type'], 'integer'],
            [['image', 'image_path', 'link', 'caption'], 'string', 'max' => 511],
            [['created_by', 'updated_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'image_path' => 'Image Path',
            'link' => 'Link',
            'caption' => 'Caption',
            'sort_order' => 'Sort Order',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'type' => 'Type',
        ];
    }
}
