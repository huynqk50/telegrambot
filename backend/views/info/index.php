<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'type',
            'slug',
            'is_active',
            // 'page_title',
            // 'h1',
            // 'meta_title',
            // 'meta_description',
            // 'meta_keywords',
            // 'long_description:ntext',
            // 'description',
            // 'content:ntext',
            // 'image',
            // 'image_path',
            // 'old_slugs',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
