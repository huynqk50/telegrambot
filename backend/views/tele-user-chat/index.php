<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TeleUserChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tele User Chats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tele-user-chat-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tele User Chat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            'chat_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
