<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TeleConversation */

$this->title = 'Update Tele Conversation: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tele Conversations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tele-conversation-update">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
