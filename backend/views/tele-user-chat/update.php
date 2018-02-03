<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TeleUserChat */

$this->title = 'Update Tele User Chat: ' . ' ' . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Tele User Chats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'chat_id' => $model->chat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tele-user-chat-update">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
