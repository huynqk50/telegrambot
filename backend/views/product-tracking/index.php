<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductTrackingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Trackings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-tracking-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Tracking', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'customization_id',
            'product_id',
            'order_quantity',
            'sold_quantity',
            // 'available_quantity',
            // 'total_quantity',
            // 'price',
            // 'original_price',
            // 'created_at',
            // 'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
