<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Redirect */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="redirect-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-12">
        <?php
        $from_urls_arr = json_decode($model->from_urls);
        is_array($from_urls_arr) or $from_urls_arr = array();
        $model->from_urls = implode("\n", $from_urls_arr);
        ?>
		<?= $form->field($model, 'from_urls')->textarea(['style' => 'resize:vertical', 'rows' => 12, 'placeholder' => "Mỗi url được viết trên một dòng, ví dụ: \n". Yii::$app->params['frontend_url'] . "/duong-dan\n" . Yii::$app->params['frontend_url'] . "/vi-du/xin-chao.html"]) ?>
		<?= $form->field($model, 'to_url')->textInput(['maxlength' => true, 'placeholder' => 'Nhập đường dẫn đầy đủ mà bạn muốn chuyển hướng đến']) ?>
		<?php // echo $form->field($model, 'created_by')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $model->isNewRecord ? $username : $model->created_by ]) ?>
		<?php // $model->created_at = $model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', $model->created_at) ?>
		<?php /* echo $form->field($model, 'created_at')->widget(TimePicker::className(), [
			'language' => 'vi',
			'mode' => 'datetime',
			'pluginOptions' => [
				'dateFormat' => 'yy-mm-dd',
				'timeFormat' => 'HH:mm:ss',
				'showSecond' => true,
			],
		]) */ ?>
		<?php // echo $form->field($model, 'updated_by')->textInput(['maxlength' => true, 'readonly' => true, 'value' => !$model->isNewRecord ? $username : '' ]) ?>
		<?php // $model->updated_at = !$model->isNewRecord ? date('Y-m-d H:i:s') : null ?>
		<?php /* echo $form->field($model, 'updated_at')->widget(TimePicker::className(), [
			'language' => 'vi',
			'mode' => 'datetime',
			'pluginOptions' => [
				'dateFormat' => 'yy-mm-dd',
				'timeFormat' => 'HH:mm:ss',
				'showSecond' => true,
			],
		]) */ ?>
		<?= $form->field($model, 'is_active')->checkbox() ?>
		<?php // echo $form->field($model, 'status')->textInput() ?>
        
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
