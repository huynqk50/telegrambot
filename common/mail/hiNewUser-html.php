<?php

use common\models\User;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $user User */

$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate-account', 'token' => $user->activation_token]);
?>
<h2>Xin chào <?= Html::encode($user->username) ?>,</h2>

<p>Chúc mừng bạn đã đăng ký thành công tài khoản tại <?= Yii::$app->name ?>.</p>
<p>Để bắt đầu sử dụng, hãy đi đến đường dẫn dưới đây để kích hoạt tài khoản:</p>

<p><?= Html::a(Html::encode($activateLink), $activateLink) ?></p>
