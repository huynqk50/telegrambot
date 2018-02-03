<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\TeleChat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tele-chat-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
    <?= $form->field($model, 'id')->textInput() ?>
    <?= $form->field($model, 'type')->dropDownList([ 'private' => 'Private', 'group' => 'Group', 'supergroup' => 'Supergroup', 'channel' => 'Channel', ], ['prompt' => '- Chọn -']) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'all_members_are_administrators')->textInput() ?>
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
    <?= $form->field($model, 'old_id')->textInput() ?>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
