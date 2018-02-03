<?php

use janisto\timepicker\TimePicker;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'clr', 'enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('firstname')])->label(false) ?>
    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('lastname')])->label(false) ?>
    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('phone_number')])->label(false) ?>
    <?php
        $model->isNewRecord or $model->dob = date('d/m/Y', $model->dob);
        
        echo $form->field($model, 'dob')->widget(TimePicker::className(), [
            'language' => Yii::$app->language,
            'mode' => 'date',
            'clientOptions'=>[
                'dateFormat' => 'dd/mm/yy'
            ]
        ]);
    ?>
    <?= $form->field($model, 'gender')->dropDownList($model->genders(), ['prompt' => 'Chọn giới tính'])->label(false) ?>
    <div class="form-group">
        <button type="submit" class="gray">Cập nhật</button>
        <button type="reset" class="link">Hủy bỏ</button>
    </div>
<?php ActiveForm::end(); ?>