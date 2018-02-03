<?php

use backend\models\Product;
use backend\models\ProductAttributeGroup;
use yii\helpers\ArrayHelper;
use backend\models\ProductCategory;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;

/* @var $this View */
/* @var $model Product */
/* @var $form ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
    <div class="col-md-6">
        <?= $form->field($model, 'category_id')->dropDownList(ProductCategory::listNoChild(), ['prompt' => 'Chọn']) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'image', ['template' => '{label}<div class="PictureCutImageContainer" ' . (!$model->isNewRecord ? 'style="background-image:url(' . $model->getImage() . ')"' : '') . '></div>{input}{error}{hint}'])->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?= $form->field($model, 'banner', ['template' => '{label}<div class="PictureCutImageContainer" ' . (!$model->isNewRecord ? 'style="background-image:url(' . $model->getBanner() . ')"' : '') . '></div>{input}{error}{hint}'])->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <?php // echo $form->field($model, 'use_duration')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'manufacturing_date')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'page_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>
        <?= $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'status')->dropDownList(Product::$statuses, ['prompt' => 'Chọn']) ?>
        <?php // echo $form->field($model, 'sort_order')->textInput() ?>
        <?php // echo $form->field($model, 'available_quantity')->textInput() ?>
        <?php // echo $form->field($model, 'order_quantity')->textInput() ?>
        <?php // echo $form->field($model, 'sold_quantity')->textInput() ?>
        <?php // echo $form->field($model, 'total_quantity')->textInput() ?>
        <?php // echo $form->field($model, 'total_revenue')->textInput() ?>
        <?php // echo $form->field($model, 'manufacturer')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'color')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'malterial')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'style')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'type')->textInput() ?>
        <?php // echo $form->field($model, 'size')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
        <?php // echo $form->field($model, 'ingredient')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'price')->textInput() ?>
        <?= $form->field($model, 'original_price')->textInput() ?>
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

    <div class="col-md-12">
        <?php
        $initial_images = [];
        $initial_config = [];
        foreach ($model->productImages as $item) {
            $initial_images[] = $item->getImage();
            $initial_config[] = ['url' => Url::to(['product/ajax-delete-product-image']), 'key' => $item->id];
        }
        echo $form->field($model, 'image_files[]')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'image/*',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'initialPreview' => $initial_images,
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => $initial_config,
                'overwriteInitial' => false,
            ]
        ]);
        ?>
    </div>
    
    <div class="col-md-12">
        <?php
        $attributes = [];
        foreach (ProductAttributeGroup::find()->all() as $group) {
            foreach ($group->productAttributes as $attribute) {
                $attributes[$group->name][$attribute->id] = $attribute->name;
            }
        }
        echo $form->field($model, 'attribute_ids')->widget(Select2::classname(), [
            'data' => $attributes,
            'language' => 'vi',
            'options' => [
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
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
            'data' => ArrayHelper::map(Product::find()->all(), 'id', 'name'),
            'language' => 'vi',
            'options' => [
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
        <?php /* echo $form->field($model, 'details')->widget(CKEditor::className(), [
            'preset' => 'full',
            'clientOptions' => [
                'height' => 400,
                'language' => Yii::$app->language,
                'uiColor' => '#E4E4E4',
                'image_previewText' => '&nbsp;',
                'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
            ],
        ]) */ ?>
        <?php /* echo $form->field($model, 'content')->widget(CKEditor::className(), [
            'preset' => 'full',
            'clientOptions' => [
		'height' => 400,
		'language' => Yii::$app->language,
		'uiColor' => '#E4E4E4',
		'image_previewText' => '&nbsp;',
		'filebrowserUploadUrl' => Url::to(['file/ckeditor-upload-image'], true),
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
