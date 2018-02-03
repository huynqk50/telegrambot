<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\UserLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-log-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
	<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>
	<?php // $model->created_at = $model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', $model->created_at) ?>
	<?php /* echo $form->field($model, 'created_at')->widget(TimePicker::className(), [
		'language' => 'vi',
		'mode' => 'datetime',
		'clientOptions' => [
			'dateFormat' => 'yy-mm-dd',
			'timeFormat' => 'HH:mm:ss',
			'showSecond' => true,
		],
	]) */ ?>
	<?= $form->field($model, 'is_success')->checkbox() ?>
	<?= $form->field($model, 'object_class')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'object_pk')->textInput() ?>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
