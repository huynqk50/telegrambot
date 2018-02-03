<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate-account', 'token' => $user->activation_token]);
?>
<h2>Xin chào <?= Html::encode($user->username) ?>,</h2>

<p>Vui lòng đi đến đường dẫn dưới đây để kích hoạt tài khoản:</p>

<p><?= Html::a(Html::encode($activateLink), $activateLink) ?></p>
