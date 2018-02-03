<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Chào bạn :)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><i>Vui lòng đăng nhập để sử dụng</i></p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->label('Tên người dùng') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Mật khẩu') ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('Ghi nhớ') ?>

                <?php // echo $form->field($model, 'reCaptcha')->widget(
//                    \himiklab\yii2\recaptcha\ReCaptcha::className(),
//                    ['siteKey' => '6Lew-x4UAAAAAI8LYzuEzP_uFC_VfurFUf-bNeQe']
//                ) ?>

                <div class="form-group">
                    <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
