<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "video_related".
 *
 * @property integer $id
 * @property integer $video_id
 * @property integer $related_id
 *
 * @property Video $video
 * @property Video $related
 */
class VideoRelated extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video_related';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video_id'], 'required'],
            [['video_id', 'related_id'], 'integer'],
            [['video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Video::className(), 'targetAttribute' => ['video_id' => 'id']],
            [['related_id'], 'exist', 'skipOnError' => true, 'targetClass' => Video::className(), 'targetAttribute' => ['related_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video_id' => 'Video ID',
            'related_id' => 'Related ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelated()
    {
        return $this->hasOne(Video::className(), ['id' => 'related_id']);
    }
}
