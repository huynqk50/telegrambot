<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseOrderDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Order Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'purchase_order_id',
            'product_customization_id',
            'product_id',
            'purchase_order_code',
            'product_code',
            'product_customization_name',
            'product_name',
            'product_description',
            'product_color',
            'product_style',
            'product_size',
            'product_weight',
            'product_model',
            'unit_price',
            'quantity',
            'discount',
        ],
    ]) ?>

</div>
