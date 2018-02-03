<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<h2>Xin chào <?= Html::encode($user->username) ?>,</h2>

<p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu của bạn vào <?= date('H:i d/m/y') ?>.</p>
<p>Vui lòng đi đến đường dẫn dưới đây để tạo mật khẩu mới:</p>

<p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
