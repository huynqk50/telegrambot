<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PurchaseOrderDetail;

/**
 * PurchaseOrderDetailSearch represents the model behind the search form about `backend\models\PurchaseOrderDetail`.
 */
class PurchaseOrderDetailSearch extends PurchaseOrderDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'purchase_order_id', 'product_customization_id', 'product_id', 'unit_price', 'quantity'], 'integer'],
            [['purchase_order_code', 'product_code', 'product_customization_name', 'product_name', 'product_description', 'product_color', 'product_style', 'product_size', 'product_weight', 'product_model'], 'safe'],
            [['discount'], 'number'],
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
        $query = PurchaseOrderDetail::find();

        if (!empty($params['purchase_order_id'])) {
            $query->where(['purchase_order_id' => $params['purchase_order_id']]);
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
            'purchase_order_id' => $this->purchase_order_id,
            'product_customization_id' => $this->product_customization_id,
            'product_id' => $this->product_id,
            'unit_price' => $this->unit_price,
            'quantity' => $this->quantity,
            'discount' => $this->discount,
        ]);

        $query->andFilterWhere(['like', 'purchase_order_code', $this->purchase_order_code])
            ->andFilterWhere(['like', 'product_code', $this->product_code])
            ->andFilterWhere(['like', 'product_customization_name', $this->product_customization_name])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_description', $this->product_description])
            ->andFilterWhere(['like', 'product_color', $this->product_color])
            ->andFilterWhere(['like', 'product_style', $this->product_style])
            ->andFilterWhere(['like', 'product_size', $this->product_size])
            ->andFilterWhere(['like', 'product_weight', $this->product_weight])
            ->andFilterWhere(['like', 'product_model', $this->product_model]);

        return $dataProvider;
    }
}
