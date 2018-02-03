<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $chat_id
 * @property string $id
 * @property integer $user_id
 * @property string $date
 * @property integer $forward_from
 * @property integer $forward_from_chat
 * @property integer $forward_from_message_id
 * @property string $forward_date
 * @property integer $reply_to_chat
 * @property string $reply_to_message
 * @property string $media_group_id
 * @property string $text
 * @property string $entities
 * @property string $audio
 * @property string $document
 * @property string $photo
 * @property string $sticker
 * @property string $video
 * @property string $voice
 * @property string $video_note
 * @property string $contact
 * @property string $location
 * @property string $venue
 * @property string $caption
 * @property string $new_chat_members
 * @property integer $left_chat_member
 * @property string $new_chat_title
 * @property string $new_chat_photo
 * @property integer $delete_chat_photo
 * @property integer $group_chat_created
 * @property integer $supergroup_chat_created
 * @property integer $channel_chat_created
 * @property integer $migrate_to_chat_id
 * @property integer $migrate_from_chat_id
 * @property string $pinned_message
 *
 * @property CallbackQuery[] $callbackQueries
 * @property EditedMessage[] $editedMessages
 * @property User $user
 * @property Chat $chat
 * @property User $forwardFrom
 * @property Chat $forwardFromChat
 * @property TeleMessage $replyToChat
 * @property TeleMessage[] $teleMessages
 * @property User $forwardFrom0
 * @property User $leftChatMember
 * @property TelegramUpdate[] $telegramUpdates
 */
class TeleMessage extends \common\models\MyActiveRecord
{

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new TeleMessage();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'TeleMessage';
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
                $log->object_class = 'TeleMessage';
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
            $log->object_class = 'TeleMessage';
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chat_id', 'id'], 'required'],
            [['chat_id', 'id', 'user_id', 'forward_from', 'forward_from_chat', 'forward_from_message_id', 'reply_to_chat', 'reply_to_message', 'left_chat_member', 'delete_chat_photo', 'group_chat_created', 'supergroup_chat_created', 'channel_chat_created', 'migrate_to_chat_id', 'migrate_from_chat_id'], 'integer'],
            [['date', 'forward_date'], 'safe'],
            [['media_group_id', 'text', 'entities', 'audio', 'document', 'photo', 'sticker', 'video', 'voice', 'video_note', 'contact', 'location', 'venue', 'caption', 'new_chat_members', 'new_chat_photo', 'pinned_message'], 'string'],
            [['new_chat_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
            'id' => 'ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'forward_from' => 'Forward From',
            'forward_from_chat' => 'Forward From Chat',
            'forward_from_message_id' => 'Forward From Message ID',
            'forward_date' => 'Forward Date',
            'reply_to_chat' => 'Reply To Chat',
            'reply_to_message' => 'Reply To Message',
            'media_group_id' => 'Media Group ID',
            'text' => 'Text',
            'entities' => 'Entities',
            'audio' => 'Audio',
            'document' => 'Document',
            'photo' => 'Photo',
            'sticker' => 'Sticker',
            'video' => 'Video',
            'voice' => 'Voice',
            'video_note' => 'Video Note',
            'contact' => 'Contact',
            'location' => 'Location',
            'venue' => 'Venue',
            'caption' => 'Caption',
            'new_chat_members' => 'New Chat Members',
            'left_chat_member' => 'Left Chat Member',
            'new_chat_title' => 'New Chat Title',
            'new_chat_photo' => 'New Chat Photo',
            'delete_chat_photo' => 'Delete Chat Photo',
            'group_chat_created' => 'Group Chat Created',
            'supergroup_chat_created' => 'Supergroup Chat Created',
            'channel_chat_created' => 'Channel Chat Created',
            'migrate_to_chat_id' => 'Migrate To Chat ID',
            'migrate_from_chat_id' => 'Migrate From Chat ID',
            'pinned_message' => 'Pinned Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallbackQueries()
    {
        return $this->hasMany(CallbackQuery::className(), ['chat_id' => 'chat_id', 'message_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditedMessages()
    {
        return $this->hasMany(EditedMessage::className(), ['chat_id' => 'chat_id', 'message_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'chat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForwardFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'forward_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForwardFromChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'forward_from_chat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplyToChat()
    {
        return $this->hasOne(TeleMessage::className(), ['chat_id' => 'reply_to_chat', 'id' => 'reply_to_message']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeleMessages()
    {
        return $this->hasMany(TeleMessage::className(), ['reply_to_chat' => 'chat_id', 'reply_to_message' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForwardFrom0()
    {
        return $this->hasOne(User::className(), ['id' => 'forward_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeftChatMember()
    {
        return $this->hasOne(User::className(), ['id' => 'left_chat_member']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTelegramUpdates()
    {
        return $this->hasMany(TelegramUpdate::className(), ['chat_id' => 'chat_id', 'message_id' => 'id']);
    }
}
