<?php

use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'clr']]); ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
    <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('new_password')])->label(false) ?>
    <?= $form->field($model, 'confirm_new_password')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('confirm_new_password')])->label(false) ?>
    <div class="form-group">
        <button type="submit" class="gray">Cập nhật</button>
    </div>
<?php ActiveForm::end(); ?>