<?php

use backend\models\User;
use janisto\timepicker\TimePicker;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model User */
/* @var $form ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
		<?= $form->field($model, 'image', ['template' => '{label}<div class="PictureCutImageContainer" ' . (!$model->isNewRecord ? 'style="background-image:url(' . $model->getImage() . ')"' : '') . '></div>{input}{error}{hint}'])->textInput(['maxlength' => true, 'readonly' => true, 'type' => 'hidden']) ?>
		<?php // echo $form->field($model, 'image_path')->textInput(['maxlength' => true, 'readonly' => true]) ?>
		<?= $form->field($model, 'gender')->dropDownList(['Nam', 'Nữ', 'Khác'], ['prompt' => '- Chọn -']) ?>
        <?php $model->dob = date('d-m-Y', $model->dob) ?>
		<?php echo $form->field($model, 'dob')->widget(TimePicker::className(), [
            'language' => 'vi',
            'mode' => 'date',
            'clientOptions'=>[
                'dateFormat' => 'dd-mm-yy',
                'showSecond' => true,
            ]
		]) ?>
    </div>
    
    <div class="col-md-6">
		<?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord]) ?>
		<?php // echo $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>
		<?php // echo $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
		<?php // echo $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
		<?php // echo $form->field($model, 'status')->textInput() ?>
		<?php // echo $model->created_at = $model->isNewRecord ? date('Y-m-d H:i:00') : date('Y-m-d H:i:s', $model->created_at) ?>
		<?php /* echo $form->field($model, 'created_at')->widget(DateTimePicker::className(), [
			'pluginOptions' => [
				'language' => 'vi',
				'todayBtn' => true,
				'autoclose' => true,
				'format' => 'yyyy-mm-dd hh:ii:00',
			],
		]) */ ?>
		<?php // echo $model->updated_at = !$model->isNewRecord ? date('Y-m-d H:i:00') : null ?>
		<?php /* echo $form->field($model, 'updated_at')->widget(DateTimePicker::className(), [
			'pluginOptions' => [
				'language' => 'vi',
				'todayBtn' => true,
				'autoclose' => true,
				'format' => 'yyyy-mm-dd hh:ii:00',
			],
		]) */ ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
		<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
		<?= $form->field($model, 'password')->passwordInput() ?>
		<?= $model->isNewRecord ? $form->field($model, 'confirm_password')->passwordInput() : '' ?>
        <?= !$model->isNewRecord ? Html::a('<span class="fa fa-plus-square-o"></span> Đổi mật khẩu', 'javascript:void(0)', ['id' => 'ChangePassword', 'class' => '', 'onclick' => '$("#NewPassword").show();']) : '' ?>
        <div id="NewPassword" style="display:none">
            <?= $form->field($model, 'new_password')->passwordInput() ?>
            <?= $form->field($model, 'confirm_new_password')->passwordInput() ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
