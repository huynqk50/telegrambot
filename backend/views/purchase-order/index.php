<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\PurchaseOrder;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Purchase Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'code',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    switch ($model->status) {
                        case PurchaseOrder::STATUS_NEW:
                            return '<span class="label label-danger">' . PurchaseOrder::statuses()[$model->status] . '</span>';
                        case PurchaseOrder::STATUS_PENDING:
                            return '<span class="label label-warning">' . PurchaseOrder::statuses()[$model->status] . '</span>';
                        case PurchaseOrder::STATUS_SUCCESS:
                            return '<span class="label label-success">' . PurchaseOrder::statuses()[$model->status] . '</span>';
                        case PurchaseOrder::STATUS_CANCELED:
                            return '<span class="label label-default">' . PurchaseOrder::statuses()[$model->status] . '</span>';
                        case PurchaseOrder::STATUS_REJECT:
                            return '<span class="label label-default">' . PurchaseOrder::statuses()[$model->status] . '</span>';
                        default:
                            return $model->status;
                    }
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return date('d / m / Y H:i', $model->created_at);
                }
            ],
//            'customer_id',
             'customer_name',
            // 'customer_email:email',
            // 'customer_phone_number',
             'customer_address',
            // 'customer_address_2',
            // 'customer_city',
            // 'customer_note',
            // 'user_note',
            // 'updated_at',
            // 'updated_by',
            // 'shipping_fee',
            // 'shipping_duration',
            // 'tax',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
