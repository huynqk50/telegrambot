<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductTracking;

/**
 * ProductTrackingSearch represents the model behind the search form about `backend\models\ProductTracking`.
 */
class ProductTrackingSearch extends ProductTracking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customization_id', 'product_id', 'order_quantity', 'sold_quantity', 'available_quantity', 'total_quantity', 'price', 'original_price'], 'integer'],
            [['created_at', 'created_by'], 'safe'],
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
        $query = ProductTracking::find();

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
            'customization_id' => $this->customization_id,
            'product_id' => $this->product_id,
            'order_quantity' => $this->order_quantity,
            'sold_quantity' => $this->sold_quantity,
            'available_quantity' => $this->available_quantity,
            'total_quantity' => $this->total_quantity,
            'price' => $this->price,
            'original_price' => $this->original_price,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'created_by', $this->created_by]);

        return $dataProvider;
    }
}
