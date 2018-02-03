<?php

use yii\widgets\ActiveForm;

?>
<div class="container" id="main">
    <div class="clr wrap news">
        <div class="clr navigation">
            <?= $this->render('//modules/breadcrumb') ?>
        </div>
        <article class="access-block">
            <div class="left">
                <h1 class="title"><?= $this->context->h1 ?></h1>
                <div class="description">
                    * Vui lòng nhập đúng email bạn đã đăng ký, chúng tôi sẽ gửi cho bạn một đường dẫn để đặt lại mật khẩu.
                </div>
            </div>
            <div class="right">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'clr']]); ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('email')])->label(false) ?>
                    <div class="form-group">
                        <button type="submit" class="gray">Gửi</button>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </article>
    </div>
</div>