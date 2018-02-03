<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductTracking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-tracking-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
    <?= $form->field($model, 'customization_id')->textInput() ?>
    <?= $form->field($model, 'product_id')->textInput() ?>
    <?= $form->field($model, 'order_quantity')->textInput() ?>
    <?= $form->field($model, 'sold_quantity')->textInput() ?>
    <?= $form->field($model, 'available_quantity')->textInput() ?>
    <?= $form->field($model, 'total_quantity')->textInput() ?>
    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'original_price')->textInput() ?>
    <?php // $model->created_at = $model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', $model->created_at) ?>
    <?php /* echo $form->field($model, 'created_at')->widget(TimePicker::className(), [
        'language' => Yii::$app->language,
        'mode' => 'datetime',
        'clientOptions' => [
            'dateFormat' => 'yy-mm-dd',
            'timeFormat' => 'HH:mm:ss',
            'showSecond' => true,
        ],
    ]) */ ?>
    <?php // echo $form->field($model, 'created_by')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $model->isNewRecord ? $username : $model->created_by ]) ?>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
