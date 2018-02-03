<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteParam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-param-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
	<?= $form->field($model, 'name')->dropDownList(backend\models\SiteParam::$params, ['prompt' => '- Chọn -']) ?>
	<?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
