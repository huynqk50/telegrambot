<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate-account', 'token' => $user->activation_token]);
?>
Xin chào <?= $user->username ?>,

Vui lòng đi đến đường dẫn dưới đây để kích hoạt tài khoản:

<?= $activateLink ?>
