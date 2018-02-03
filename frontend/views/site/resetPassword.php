<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="access-block">
    <h2 class="title"><?= $this->context->h1 ?></h2>
    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Lưu', ['class' => '_3d']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>