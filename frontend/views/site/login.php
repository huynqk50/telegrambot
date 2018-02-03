<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="container" id="main">
    <div class="clr wrap news">
        <div class="clr navigation">
            <?= $this->render('//modules/breadcrumb') ?>
        </div>
        <article class="access-block">
            <div class="left">
                <h1 class="title">Đăng nhập</h1>
                <div class="description">
                    * Vui lòng nhập tên đăng nhập và mật khẩu
                </div>
                <?= Html::a('Quên mật khẩu?', ['site/request-password-reset'], ['class' => 'block link']) ?>
            </div>
            <div class="right">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'clr']]); ?>
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('username')])->label(false) ?>
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
                    <div class="form-group">
                        <button type="submit" class="gray">Đăng nhập</button>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </article>
    </div>
</div>