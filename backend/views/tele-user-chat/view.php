<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TeleUserChat */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Tele User Chats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tele-user-chat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'user_id' => $model->user_id, 'chat_id' => $model->chat_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'user_id' => $model->user_id, 'chat_id' => $model->chat_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'chat_id',
        ],
    ]) ?>

</div>
