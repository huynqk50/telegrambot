<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TeleMessage;

/**
 * TeleMessageSearch represents the model behind the search form about `backend\models\TeleMessage`.
 */
class TeleMessageSearch extends TeleMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chat_id', 'id', 'user_id', 'forward_from', 'forward_from_chat', 'forward_from_message_id', 'reply_to_chat', 'reply_to_message', 'left_chat_member', 'delete_chat_photo', 'group_chat_created', 'supergroup_chat_created', 'channel_chat_created', 'migrate_to_chat_id', 'migrate_from_chat_id'], 'integer'],
            [['date', 'forward_date', 'media_group_id', 'text', 'entities', 'audio', 'document', 'photo', 'sticker', 'video', 'voice', 'video_note', 'contact', 'location', 'venue', 'caption', 'new_chat_members', 'new_chat_title', 'new_chat_photo', 'pinned_message'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TeleMessage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'chat_id' => $this->chat_id,
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'forward_from' => $this->forward_from,
            'forward_from_chat' => $this->forward_from_chat,
            'forward_from_message_id' => $this->forward_from_message_id,
            'forward_date' => $this->forward_date,
            'reply_to_chat' => $this->reply_to_chat,
            'reply_to_message' => $this->reply_to_message,
            'left_chat_member' => $this->left_chat_member,
            'delete_chat_photo' => $this->delete_chat_photo,
            'group_chat_created' => $this->group_chat_created,
            'supergroup_chat_created' => $this->supergroup_chat_created,
            'channel_chat_created' => $this->channel_chat_created,
            'migrate_to_chat_id' => $this->migrate_to_chat_id,
            'migrate_from_chat_id' => $this->migrate_from_chat_id,
        ]);

        $query->andFilterWhere(['like', 'media_group_id', $this->media_group_id])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'entities', $this->entities])
            ->andFilterWhere(['like', 'audio', $this->audio])
            ->andFilterWhere(['like', 'document', $this->document])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'sticker', $this->sticker])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'voice', $this->voice])
            ->andFilterWhere(['like', 'video_note', $this->video_note])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'venue', $this->venue])
            ->andFilterWhere(['like', 'caption', $this->caption])
            ->andFilterWhere(['like', 'new_chat_members', $this->new_chat_members])
            ->andFilterWhere(['like', 'new_chat_title', $this->new_chat_title])
            ->andFilterWhere(['like', 'new_chat_photo', $this->new_chat_photo])
            ->andFilterWhere(['like', 'pinned_message', $this->pinned_message]);

        return $dataProvider;
    }
}
