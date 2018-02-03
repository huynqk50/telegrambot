<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TeleChat;

/**
 * TeleChatSearch represents the model behind the search form about `backend\models\TeleChat`.
 */
class TeleChatSearch extends TeleChat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'all_members_are_administrators', 'old_id'], 'integer'],
            [['type', 'title', 'username', 'created_at', 'updated_at'], 'safe'],
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
        $query = TeleChat::find();

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
            'id' => $this->id,
            'all_members_are_administrators' => $this->all_members_are_administrators,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'old_id' => $this->old_id,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
