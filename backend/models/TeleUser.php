<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $is_bot
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $language_code
 * @property string $created_at
 * @property string $updated_at
 *
 * @property BotanShortener[] $botanShorteners
 * @property CallbackQuery[] $callbackQueries
 * @property ChosenInlineResult[] $chosenInlineResults
 * @property Conversation[] $conversations
 * @property EditedMessage[] $editedMessages
 * @property InlineQuery[] $inlineQueries
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property Message[] $messages1
 * @property Message[] $messages2
 * @property UserChat[] $userChats
 * @property Chat[] $chats
 */
class TeleUser extends \common\models\MyActiveRecord
{

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new TeleUser();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'TeleUser';
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
                $log->object_class = 'TeleUser';
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
            $log->object_class = 'TeleUser';
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
        return 'user';
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
            [['id'], 'required'],
            [['id', 'is_bot'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 191],
            [['language_code'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_bot' => 'Is Bot',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'language_code' => 'Language Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBotanShorteners()
    {
        return $this->hasMany(BotanShortener::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallbackQueries()
    {
        return $this->hasMany(CallbackQuery::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChosenInlineResults()
    {
        return $this->hasMany(ChosenInlineResult::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversations()
    {
        return $this->hasMany(Conversation::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditedMessages()
    {
        return $this->hasMany(EditedMessage::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInlineQueries()
    {
        return $this->hasMany(InlineQuery::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::className(), ['forward_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages1()
    {
        return $this->hasMany(Message::className(), ['forward_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages2()
    {
        return $this->hasMany(Message::className(), ['left_chat_member' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserChats()
    {
        return $this->hasMany(UserChat::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['id' => 'chat_id'])->viaTable('user_chat', ['user_id' => 'id']);
    }
}
