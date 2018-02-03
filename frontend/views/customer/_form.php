<?php

use himiklab\yii2\recaptcha\ReCaptcha;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'clr', 'enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('username')])->label(false) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('email')])->label(false) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('confirm_password')])->label(false) ?>
    <?= $form->field($model, 'captcha')->widget(
            ReCaptcha::className(), [
                'siteKey' => Yii::$app->params['recaptcha.site_key'],
                'widgetOptions' => []
            ]
        )->label(false)
    ?>
    <div class="form-group">
        <button type="submit" class="gray">Đăng ký</button>
    </div>
<?php ActiveForm::end(); ?>