<?php

use yii\helpers\Html;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate-account', 'token' => $user->activation_token]);
?>
Xin chào <?= Html::encode($user->username) ?>,

Chúc mừng bạn đã đăng ký thành công tài khoản tại <?= Yii::$app->name ?>.
Để bắt đầu sử dụng, hãy đi đến đường dẫn dưới đây để kích hoạt tài khoản:

<?= $activateLink ?>
