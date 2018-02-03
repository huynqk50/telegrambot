<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TeleUserChat */

$this->title = 'Create Tele User Chat';
$this->params['breadcrumbs'][] = ['label' => 'Tele User Chats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tele-user-chat-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
