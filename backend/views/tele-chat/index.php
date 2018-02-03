<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TeleChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tele Chats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tele-chat-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tele Chat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'title',
            'username',
            'all_members_are_administrators',
            // 'created_at',
            // 'updated_at',
            // 'old_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
