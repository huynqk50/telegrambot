<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TeleConversation */

$this->title = 'Create Tele Conversation';
$this->params['breadcrumbs'][] = ['label' => 'Tele Conversations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tele-conversation-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
