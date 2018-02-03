<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TeleMessage */

$this->title = $model->chat_id;
$this->params['breadcrumbs'][] = ['label' => 'Tele Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tele-message-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'chat_id' => $model->chat_id, 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'chat_id' => $model->chat_id, 'id' => $model->id], [
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
            'chat_id',
            'id',
            'user_id',
            'date',
            'forward_from',
            'forward_from_chat',
            'forward_from_message_id',
            'forward_date',
            'reply_to_chat',
            'reply_to_message',
            'media_group_id:ntext',
            'text:ntext',
            'entities:ntext',
            'audio:ntext',
            'document:ntext',
            'photo:ntext',
            'sticker:ntext',
            'video:ntext',
            'voice:ntext',
            'video_note:ntext',
            'contact:ntext',
            'location:ntext',
            'venue:ntext',
            'caption:ntext',
            'new_chat_members:ntext',
            'left_chat_member',
            'new_chat_title',
            'new_chat_photo:ntext',
            'delete_chat_photo',
            'group_chat_created',
            'supergroup_chat_created',
            'channel_chat_created',
            'migrate_to_chat_id',
            'migrate_from_chat_id',
            'pinned_message:ntext',
        ],
    ]) ?>

</div>
