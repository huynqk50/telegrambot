<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Product;

/**
 * ProductSearch represents the model behind the search form about `frontend\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'price', 'original_price', 'is_hot', 'is_active', 'status', 'sort_order', 'view_count', 'like_count', 'share_count', 'comment_count', 'published_at', 'created_at', 'updated_at', 'available_quantity', 'order_quantity', 'sold_quantity', 'total_quantity', 'total_revenue', 'review_score', 'type'], 'integer'],
            [['name', 'label', 'slug', 'code', 'old_slugs', 'image', 'banner', 'image_path', 'description', 'long_description', 'details', 'content', 'page_title', 'h1', 'meta_title', 'meta_description', 'meta_keywords', 'created_by', 'updated_by', 'auth_alias', 'manufacturer', 'color', 'malterial', 'style', 'use_duration', 'manufacturing_date', 'size', 'weight', 'ingredient', 'model'], 'safe'],
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
    public function search($params, $query)
    {
        if (!$query) {
            $query = Product::find();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'original_price' => $this->original_price,
            'is_hot' => $this->is_hot,
            'is_active' => $this->is_active,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'view_count' => $this->view_count,
            'like_count' => $this->like_count,
            'share_count' => $this->share_count,
            'comment_count' => $this->comment_count,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'available_quantity' => $this->available_quantity,
            'order_quantity' => $this->order_quantity,
            'sold_quantity' => $this->sold_quantity,
            'total_quantity' => $this->total_quantity,
            'total_revenue' => $this->total_revenue,
            'review_score' => $this->review_score,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'old_slugs', $this->old_slugs])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'banner', $this->banner])
            ->andFilterWhere(['like', 'image_path', $this->image_path])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'long_description', $this->long_description])
            ->andFilterWhere(['like', 'details', $this->details])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'page_title', $this->page_title])
            ->andFilterWhere(['like', 'h1', $this->h1])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'auth_alias', $this->auth_alias])
            ->andFilterWhere(['like', 'manufacturer', $this->manufacturer])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'malterial', $this->malterial])
            ->andFilterWhere(['like', 'style', $this->style])
            ->andFilterWhere(['like', 'use_duration', $this->use_duration])
            ->andFilterWhere(['like', 'manufacturing_date', $this->manufacturing_date])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'ingredient', $this->ingredient])
            ->andFilterWhere(['like', 'model', $this->model]);

        return $dataProvider;
    }
}
