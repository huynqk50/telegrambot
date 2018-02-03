<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Xin chào <?= $user->username ?>,

Chúng tôi nhận được yêu cầu đặt lại mật khẩu của bạn vào <?= date('H:i d/m/y') ?>.
Vui lòng đi đến đường dẫn dưới đây để đặt mật khẩu:

<?= $resetLink ?>
