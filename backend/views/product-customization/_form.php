<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use janisto\timepicker\TimePicker;
use kartik\select2\Select2;
use backend\models\ProductOptionGroup;
use backend\models\ProductImage;
use kartik\file\FileInput;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCustomization */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="product-customization-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'label')->textInput() ?>
        <?= $form->field($model, 'sort_order')->textInput() ?>
        <?php
        $images = [];
        foreach ($model->product->productImages as $item) {
            $images[$item->id] =
                "{$item->img(['style' => 'max-width:60px;max-height:60px;display:inline-block'], ProductImage::IMAGE_SMALL)}
                &nbsp; <span>$item->image</span>";
        }
        echo $form->field($model, 'image_ids')->widget(Select2::classname(), [
            'data' => $images,
            'language' => 'vi',
            'options' => [
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true,
                // Allow HTML tags:
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            ],
        ]);
        $this->registerCss(
            ".select2-container--krajee .select2-selection--multiple
             .select2-selection__choice {margin: 5px !important;}"
        );
        ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'price')->textInput() ?>
        <?= $form->field($model, 'original_price')->textInput() ?>
        <?= $form->field($model, 'total_quantity')->textInput() ?>
        <?= $form->field($model, 'available_quantity')->textInput() ?>
        <?php
        $options = [];
        foreach (ProductOptionGroup::find()->all() as $group) {
            foreach ($group->productOptions as $option) {
                $options[$group->name][$option->id] = $option->name;
            }
        }
        echo $form->field($model, 'option_ids')->widget(Select2::classname(), [
            'data' => $options,
            'language' => 'vi',
            'options' => [
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>

    <!--    <div class="col-md-12">
        <?php
    /*        $initial_images = [];
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
            */ ?>
    </div>-->

    <div class="col-md-12">
        <?= $form->field($model, 'product_id')->hiddenInput(['readonly' => true])->label(false) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
