<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseOrderDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'purchase_order_id') ?>

    <?= $form->field($model, 'product_customization_id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'purchase_order_code') ?>

    <?php // echo $form->field($model, 'product_code') ?>

    <?php // echo $form->field($model, 'product_customization_name') ?>

    <?php // echo $form->field($model, 'product_name') ?>

    <?php // echo $form->field($model, 'product_description') ?>

    <?php // echo $form->field($model, 'product_color') ?>

    <?php // echo $form->field($model, 'product_style') ?>

    <?php // echo $form->field($model, 'product_size') ?>

    <?php // echo $form->field($model, 'product_weight') ?>

    <?php // echo $form->field($model, 'product_model') ?>

    <?php // echo $form->field($model, 'unit_price') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
