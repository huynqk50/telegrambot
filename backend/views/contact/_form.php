<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;
use backend\models\Contact;

/* @var $this yii\web\View */
/* @var $model backend\models\Contact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?= $form->field($model, 'message')->textarea(['maxlength' => true, 'readonly' => true, 'rows' => 5]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?= $form->field($model, 'status')->dropDownList(Contact::$statues, ['prompt' => 'Chọn']) ?>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
