<?php

use backend\models\PurchaseOrder;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model PurchaseOrder */
/* @var $form ActiveForm */
?>

<div class="purchase-order-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
        <?= $form->field($model, 'code')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'status')->dropDownList(PurchaseOrder::statuses(), ['prompt' => 'Chọn']) ?>
        <?= $form->field($model, 'shipping_fee')->textInput() ?>
        <?= $form->field($model, 'shipping_duration')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'user_note')->textarea(['maxlength' => true, 'style' => 'resize:vertical']) ?>
    </div>
    
    <div class="col-md-6">
        <?= $form->field($model, 'customer_name')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'customer_email')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'customer_phone_number')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'customer_address')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'customer_address_2')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'customer_city')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'customer_note')->textarea(['readonly' => true, 'style' => 'resize:vertical']) ?>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
