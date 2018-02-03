<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\TeleMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tele-message-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
    <?= $form->field($model, 'chat_id')->textInput() ?>
    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'date')->textInput() ?>
    <?= $form->field($model, 'forward_from')->textInput() ?>
    <?= $form->field($model, 'forward_from_chat')->textInput() ?>
    <?= $form->field($model, 'forward_from_message_id')->textInput() ?>
    <?= $form->field($model, 'forward_date')->textInput() ?>
    <?= $form->field($model, 'reply_to_chat')->textInput() ?>
    <?= $form->field($model, 'reply_to_message')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'media_group_id')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'entities')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'audio')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'document')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'photo')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'sticker')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'video')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'voice')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'video_note')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'contact')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'location')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'venue')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'caption')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'new_chat_members')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'left_chat_member')->textInput() ?>
    <?= $form->field($model, 'new_chat_title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'new_chat_photo')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    <?= $form->field($model, 'delete_chat_photo')->textInput() ?>
    <?= $form->field($model, 'group_chat_created')->textInput() ?>
    <?= $form->field($model, 'supergroup_chat_created')->textInput() ?>
    <?= $form->field($model, 'channel_chat_created')->textInput() ?>
    <?= $form->field($model, 'migrate_to_chat_id')->textInput() ?>
    <?= $form->field($model, 'migrate_from_chat_id')->textInput() ?>
    <?= $form->field($model, 'pinned_message')->widget(CKEditor::className(), [
        'preset' => 'full',
        'clientOptions' => [
            'height' => 400,
            'language' => Yii::$app->language,
            'uiColor' => '#E4E4E4',
            'image_previewText' => '&nbsp;',
            'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
        ],
    ]) ?>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
