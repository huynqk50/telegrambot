<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TeleMessage */

$this->title = 'Update Tele Message: ' . ' ' . $model->chat_id;
$this->params['breadcrumbs'][] = ['label' => 'Tele Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->chat_id, 'url' => ['view', 'chat_id' => $model->chat_id, 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tele-message-update">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
