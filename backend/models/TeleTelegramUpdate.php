<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "telegram_update".
 *
 * @property string $id
 * @property integer $chat_id
 * @property string $message_id
 * @property string $inline_query_id
 * @property string $chosen_inline_result_id
 * @property string $callback_query_id
 * @property string $edited_message_id
 *
 * @property Message $chat
 * @property InlineQuery $inlineQuery
 * @property ChosenInlineResult $chosenInlineResult
 * @property CallbackQuery $callbackQuery
 * @property EditedMessage $editedMessage
 */
class TeleTelegramUpdate extends \common\models\MyActiveRecord
{

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new TeleTelegramUpdate();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'TeleTelegramUpdate';
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
                $log->object_class = 'TeleTelegramUpdate';
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
            $log->object_class = 'TeleTelegramUpdate';
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
        return 'telegram_update';
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
            [['id', 'chat_id', 'message_id', 'inline_query_id', 'chosen_inline_result_id', 'callback_query_id', 'edited_message_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'message_id' => 'Message ID',
            'inline_query_id' => 'Inline Query ID',
            'chosen_inline_result_id' => 'Chosen Inline Result ID',
            'callback_query_id' => 'Callback Query ID',
            'edited_message_id' => 'Edited Message ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Message::className(), ['chat_id' => 'chat_id', 'id' => 'message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInlineQuery()
    {
        return $this->hasOne(InlineQuery::className(), ['id' => 'inline_query_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChosenInlineResult()
    {
        return $this->hasOne(ChosenInlineResult::className(), ['id' => 'chosen_inline_result_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCallbackQuery()
    {
        return $this->hasOne(CallbackQuery::className(), ['id' => 'callback_query_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditedMessage()
    {
        return $this->hasOne(EditedMessage::className(), ['id' => 'edited_message_id']);
    }
}
