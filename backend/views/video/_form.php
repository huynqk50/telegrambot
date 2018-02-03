<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;
use yii\helpers\ArrayHelper;
use backend\models\Video;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
    <?php //echo $form->field($model, 'category_id')->textInput() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php //echo $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
    <?php // echo $form->field($model, 'old_slugs')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?= $form->field($model, 'image', ['template' => '{label}<div class="PictureCutImageContainer" ' . (!$model->isNewRecord ? 'style="background-image:url(' . $model->getImage() . ')"' : '') . '></div>{input}{error}{hint}'])->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?php // echo $form->field($model, 'image_path')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>
    <?php $model->published_at = $model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', $model->published_at) ?>
    <?= $form->field($model, 'published_at')->widget(TimePicker::className(), [
        'language' => Yii::$app->language,
        'mode' => 'datetime',
        'clientOptions' => [
            'dateFormat' => 'yy-mm-dd',
            'timeFormat' => 'HH:mm:ss',
            'showSecond' => true,
        ],
    ]) ?>
    <?= $form->field($model, 'is_hot')->checkbox() ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'page_title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>
    <?= $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
    <?php //echo $form->field($model, 'view_count')->textInput() ?>
    <?php //echo $form->field($model, 'like_count')->textInput() ?>
    <?php //echo $form->field($model, 'comment_count')->textInput() ?>
    <?php //echo $form->field($model, 'share_count')->textInput() ?>
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
    <?php // echo $form->field($model, 'created_by')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $model->isNewRecord ? $username : $model->created_by ]) ?>
    <?php // echo $form->field($model, 'updated_by')->textInput(['maxlength' => true, 'readonly' => true, 'value' => !$model->isNewRecord ? $username : '' ]) ?>
    <?php //echo $form->field($model, 'auth_alias')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sort_order')->textInput() ?>
    <?php //echo $form->field($model, 'status')->textInput() ?>
    <?php //echo $form->field($model, 'type')->textInput() ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'related_ids')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Video::find()->all(), 'id', 'name'),
            'language' => 'vi',
            'options' => [
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'long_description')->widget(CKEditor::className(), [
            'preset' => 'full',
            'clientOptions' => [
                'height' => 400,
                'language' => Yii::$app->language,
                'uiColor' => '#E4E4E4',
                'image_previewText' => '&nbsp;',
                'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
            ],
        ]) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
