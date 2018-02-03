<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseOrder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-view">

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
            'code',
            'status',
            'created_at',
            'customer_id',
            'customer_name',
            'customer_email:email',
            'customer_phone_number',
            'customer_address',
            'customer_address_2',
            'customer_city',
            'customer_note',
            'user_note',
            'updated_at',
            'updated_by',
            'shipping_fee',
            'shipping_duration',
            'tax',
        ],
    ]) ?>

</div>
