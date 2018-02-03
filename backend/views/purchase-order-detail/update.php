<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseOrderDetail */

$this->title = 'Update Purchase Order Detail: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Order Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchase-order-detail-update">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
