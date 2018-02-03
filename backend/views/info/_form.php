<?php

use backend\models\Info as Info2;
use common\models\Info;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Info2 */
/* @var $form ActiveForm */
?>

<div class="info-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'image', ['template' => '{label}<div class="PictureCutImageContainer" ' . (!$model->isNewRecord ? 'style="background-image:url(' . $model->getImage() . ')"' : '') . '></div>{input}{error}{hint}'])->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'type')->dropDownList(Info::$types, ['prompt' => 'Chọn']) ?>
        <?= $form->field($model, 'page_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
        <?php /* echo $form->field($model, 'long_description')->widget(CKEditor::className(), [
            'preset' => 'full',
            'clientOptions' => [
                'height' => 400,
                'language' => 'vi',
                'uiColor' => '#E4E4E4',
                'image_previewText' => '&nbsp;',
                'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
            ],
        ]) */ ?>
        <?php // echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'image_path')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?php // echo $form->field($model, 'old_slugs')->textInput(['maxlength' => true, 'readonly' => true]) ?>
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
        <?php // echo $form->field($model, 'created_by')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $model->isNewRecord ? $username : $model->created_by ]) ?>
        <?php // $model->updated_at = !$model->isNewRecord ? date('Y-m-d H:i:s') : null ?>
        <?php /* echo $form->field($model, 'updated_at')->widget(TimePicker::className(), [
            'language' => 'vi',
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
        <?= $form->field($model, 'content')->widget(CKEditor::className(), [
            'preset' => 'full',
            'clientOptions' => [
                'height' => 400,
                'language' => 'vi',
                'uiColor' => '#E4E4E4',
                'image_previewText' => '&nbsp;',
                'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
                'allowedContent' => true,
                
            ],
        ]) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
