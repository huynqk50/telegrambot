<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCustomization */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Customizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-customization-view">

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
            'product_id',
            'name',
            'label',
            'review_score',
            'order_quantity',
            'sold_quantity',
            'available_quantity',
            'total_quantity',
            'price',
            'original_price',
            'total_revenue',
            'sort_order',
        ],
    ]) ?>

</div>
