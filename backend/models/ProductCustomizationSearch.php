<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductCustomization;

/**
 * ProductCustomizationSearch represents the model behind the search form about `backend\models\ProductCustomization`.
 */
class ProductCustomizationSearch extends ProductCustomization
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'review_score', 'order_quantity', 'sold_quantity', 'available_quantity', 'total_quantity', 'price', 'original_price', 'total_revenue', 'sort_order'], 'integer'],
            [['name', 'label'], 'safe'],
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
        $query = ProductCustomization::find();

        if (!empty($params['product_id'])) {
            $query->where(['product_id' => $params['product_id']]);
        }

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
            'product_id' => $this->product_id,
            'review_score' => $this->review_score,
            'order_quantity' => $this->order_quantity,
            'sold_quantity' => $this->sold_quantity,
            'available_quantity' => $this->available_quantity,
            'total_quantity' => $this->total_quantity,
            'price' => $this->price,
            'original_price' => $this->original_price,
            'total_revenue' => $this->total_revenue,
            'sort_order' => $this->sort_order,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}
