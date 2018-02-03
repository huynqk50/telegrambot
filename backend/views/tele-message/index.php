<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TeleMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tele Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tele-message-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tele Message', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'chat_id',
            'id',
            'user_id',
            'date',
            'forward_from',
            // 'forward_from_chat',
            // 'forward_from_message_id',
            // 'forward_date',
            // 'reply_to_chat',
            // 'reply_to_message',
            // 'media_group_id:ntext',
            // 'text:ntext',
            // 'entities:ntext',
            // 'audio:ntext',
            // 'document:ntext',
            // 'photo:ntext',
            // 'sticker:ntext',
            // 'video:ntext',
            // 'voice:ntext',
            // 'video_note:ntext',
            // 'contact:ntext',
            // 'location:ntext',
            // 'venue:ntext',
            // 'caption:ntext',
            // 'new_chat_members:ntext',
            // 'left_chat_member',
            // 'new_chat_title',
            // 'new_chat_photo:ntext',
            // 'delete_chat_photo',
            // 'group_chat_created',
            // 'supergroup_chat_created',
            // 'channel_chat_created',
            // 'migrate_to_chat_id',
            // 'migrate_from_chat_id',
            // 'pinned_message:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
