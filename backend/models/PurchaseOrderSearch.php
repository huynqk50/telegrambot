<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PurchaseOrder;

/**
 * PurchaseOrderSearch represents the model behind the search form about `backend\models\PurchaseOrder`.
 */
class PurchaseOrderSearch extends PurchaseOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'customer_id', 'shipping_fee', 'tax'], 'integer'],
            [['code', 'created_at', 'customer_name', 'customer_email', 'customer_phone_number', 'customer_address', 'customer_address_2', 'customer_city', 'customer_note', 'user_note', 'updated_at', 'updated_by', 'shipping_duration'], 'safe'],
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
        $query = PurchaseOrder::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'customer_id' => $this->customer_id,
            'updated_at' => $this->updated_at,
            'shipping_fee' => $this->shipping_fee,
            'tax' => $this->tax,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_email', $this->customer_email])
            ->andFilterWhere(['like', 'customer_phone_number', $this->customer_phone_number])
            ->andFilterWhere(['like', 'customer_address', $this->customer_address])
            ->andFilterWhere(['like', 'customer_address_2', $this->customer_address_2])
            ->andFilterWhere(['like', 'customer_city', $this->customer_city])
            ->andFilterWhere(['like', 'customer_note', $this->customer_note])
            ->andFilterWhere(['like', 'user_note', $this->user_note])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'shipping_duration', $this->shipping_duration]);

        return $dataProvider;
    }
}
