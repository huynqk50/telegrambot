<?php

use backend\models\Article;
use backend\models\ArticleCategory;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this View */
/* @var $model Article */
/* @var $form ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
        <?= $form->field($model, 'category_id')->dropDownList(ArticleCategory::listNoChild(), ['prompt' => 'Chọn']) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'image', ['template' => '{label}<div class="PictureCutImageContainer" ' . (!$model->isNewRecord ? 'style="background-image:url(' . $model->getImage() . ')"' : '') . '></div>{input}{error}{hint}'])->textInput(['maxlength' => true, 'readonly' => true]) ?>
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
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'page_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        <?php //echo $form->field($model, 'sort_order')->textInput() ?>
        <?php echo $form->field($model, 'status')->dropDownList(Article::$statuses, ['prompt' => 'Chọn']) ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>
        <?php //echo $form->field($model, 'is_hot')->checkbox() ?>
    </div>
    
    <div class="col-md-12">
        <?php /* echo $form->field($model, 'long_description')->widget(CKEditor::className(), [
            'preset' => 'full',
            'clientOptions' => [
                'height' => 400,
                'language' => Yii::$app->language,
                'uiColor' => '#E4E4E4',
                'image_previewText' => '&nbsp;',
                'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
            ],
        ]) */ ?>
        <?= $form->field($model, 'content')->widget(CKEditor::className(), [
            'preset' => 'full',
            'clientOptions' => [
                'height' => 400,
                'language' => Yii::$app->language,
                'uiColor' => '#E4E4E4',
                'image_previewText' => '&nbsp;',
                'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
            ],
        ]) ?>
        <?= $form->field($model, 'related_ids')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Article::find()->allActive(), 'id', 'name'),
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
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
