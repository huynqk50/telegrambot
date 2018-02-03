<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\SlideshowItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slideshow-item-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
<?= $form->field($model, 'image', ['template' => '{label}<div class="PictureCutImageContainer" ' . (!$model->isNewRecord ? 'style="background-image:url(' . $model->getImage() . ')"' : '') . '></div>{input}{error}{hint}'])->textInput(['maxlength' => true, 'readonly' => true]) ?>
<?php // echo $form->field($model, 'image_path')->textInput(['maxlength' => true, 'readonly' => true]) ?>
<?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'caption')->textarea(['maxlength' => true]) ?>
<?= $form->field($model, 'sort_order')->textInput() ?>
<?= $form->field($model, 'is_active')->checkbox() ?>
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
<?php // $model->updated_at = !$model->isNewRecord ? date('Y-m-d H:i:s') : null ?>
<?php /* echo $form->field($model, 'updated_at')->widget(TimePicker::className(), [
	'language' => Yii::$app->language,
	'mode' => 'datetime',
	'clientOptions' => [
		'dateFormat' => 'yy-mm-dd',
		'timeFormat' => 'HH:mm:ss',
		'showSecond' => true,
	],
]) */ ?>
<?php // echo $form->field($model, 'updated_by')->textInput(['maxlength' => true, 'readonly' => true, 'value' => !$model->isNewRecord ? $username : '' ]) ?>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
