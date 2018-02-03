<?php

use backend\models\ArticleCategory;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model ArticleCategory */
/* @var $form ActiveForm */
?>

<div class="article-category-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
        <?= $form->field($model, 'parent_id')->dropDownList(ArticleCategory::listNoArticle(), ['prompt' => 'Chọn']) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'image', ['template' => '{label}<div class="PictureCutImageContainer" ' . (!$model->isNewRecord ? 'style="background-image:url(' . $model->getImage() . ')"' : '') . '></div>{input}{error}{hint}'])->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>
        <?= $form->field($model, 'is_hot')->checkbox() ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'page_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        <?= $form->field($model, 'type')->dropDownList(ArticleCategory::$types, ['prompt' => '- Chọn -']) ?>
        <?= $form->field($model, 'sort_order')->textInput() ?>
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
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
