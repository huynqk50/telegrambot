<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'action') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'is_success') ?>

    <?php // echo $form->field($model, 'object_class') ?>

    <?php // echo $form->field($model, 'object_pk') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
