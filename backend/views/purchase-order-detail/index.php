<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase Order Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-detail-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Purchase Order Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'purchase_order_id',
            'product_customization_id',
            'product_id',
            'purchase_order_code',
            // 'product_code',
            // 'product_customization_name',
            // 'product_name',
            // 'product_description',
            // 'product_color',
            // 'product_style',
            // 'product_size',
            // 'product_weight',
            // 'product_model',
            // 'unit_price',
            // 'quantity',
            // 'discount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
