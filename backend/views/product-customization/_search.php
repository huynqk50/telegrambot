<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCustomizationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-customization-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'label') ?>

    <?= $form->field($model, 'review_score') ?>

    <?php // echo $form->field($model, 'order_quantity') ?>

    <?php // echo $form->field($model, 'sold_quantity') ?>

    <?php // echo $form->field($model, 'available_quantity') ?>

    <?php // echo $form->field($model, 'total_quantity') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'original_price') ?>

    <?php // echo $form->field($model, 'total_revenue') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
