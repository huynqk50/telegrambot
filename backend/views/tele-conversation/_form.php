<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\TeleConversation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tele-conversation-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
    <?= $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'chat_id')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'cancelled' => 'Cancelled', 'stopped' => 'Stopped', ], ['prompt' => '- Chọn -']) ?>
    <?= $form->field($model, 'command')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'notes')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
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
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
