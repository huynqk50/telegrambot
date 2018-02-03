<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseOrderDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-order-detail-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
        <?= $form->field($model, 'purchase_order_code')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'unit_price')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'quantity')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'discount')->textInput() ?>
        <?= $form->field($model, 'purchase_order_id')->hiddenInput(['readonly' => true])->label(false) ?>
    </div>
    
    <div class="col-md-6">
        <?= $form->field($model, 'product_id')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'product_code')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'product_name')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'product_description')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'product_color')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'product_style')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'product_size')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'product_weight')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'product_model')->textInput(['readonly' => true]) ?>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
