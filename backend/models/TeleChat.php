<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $type
 * @property string $title
 * @property string $username
 * @property integer $all_members_are_administrators
 * @property string $created_at
 * @property string $updated_at
 * @property integer $old_id
 *
 * @property Conversation[] $conversations
 * @property EditedMessage[] $editedMessages
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property UserChat[] $userChats
 * @property User[] $users
 */
class TeleChat extends \common\models\MyActiveRecord
{

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new TeleChat();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'TeleChat';
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            $model->created_at = $now;
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
                $log->object_class = 'TeleChat';
                $log->object_pk = $this->id;
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            $this->updated_at = $now;
            
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
            $log->object_class = 'TeleChat';
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
        return 'chat';
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
            [['id', 'type'], 'required'],
            [['id', 'all_members_are_administrators', 'old_id'], 'integer'],
            [['type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'username'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'title' => 'Title',
            'username' => 'Username',
            'all_members_are_administrators' => 'All Members Are Administrators',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'old_id' => 'Old ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversations()
    {
        return $this->hasMany(Conversation::className(), ['chat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditedMessages()
    {
        return $this->hasMany(EditedMessage::className(), ['chat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['chat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::className(), ['forward_from_chat' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserChats()
    {
        return $this->hasMany(UserChat::className(), ['chat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_chat', ['chat_id' => 'id']);
    }
}
