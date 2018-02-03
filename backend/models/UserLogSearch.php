<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserLog;

/**
 * UserLogSearch represents the model behind the search form about `backend\models\UserLog`.
 */
class UserLogSearch extends UserLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_success', 'object_pk'], 'integer'],
            [['username', 'action', 'created_at', 'object_class'], 'safe'],
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
        $query = UserLog::find();

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
            'created_at' => $this->created_at,
            'is_success' => $this->is_success,
            'object_pk' => $this->object_pk,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'object_class', $this->object_class]);

        return $dataProvider;
    }
}
