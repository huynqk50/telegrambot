<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TeleChat */

$this->title = 'Create Tele Chat';
$this->params['breadcrumbs'][] = ['label' => 'Tele Chats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tele-chat-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
