<?php

use backend\models\TagSearch;
use backend\models\User;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel TagSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tag', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img($model->getImage(), ['style'=>'max-height:100px;max-width:100px']);
                },
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name, $model->getLink(), ['style'=>'color:#04a', 'target' => '_blank']);
                },
            ],
            'slug',
            [
                'attribute' => 'published_at',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->published_at <= strtotime('now')) {
                        return Html::tag('span', date('Y-m-d H:i', $model->published_at), ['class' => 'text-black']);
                    } else {
                        return Html::tag('span', '<span class="fa fa-clock-o"></span> ' . date('Y-m-d H:i', $model->published_at), ['class' => 'label label-warning']);
                    }
                },
            ],
            [
                'attribute' => 'created_by',
                'filter' => Html::activeDropDownList($searchModel, 'created_by', ArrayHelper::merge(ArrayHelper::map(User::find()->asArray()->all(), 'username', 'username'), [0 => 'N/A']), ['class'=>'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_active === 1 ? Html::tag('span', 'Ok', ['class' => 'label label-success']) : Html::tag('span', '<span class="fa fa-close"></span>', ['class' => 'label label-danger']);
                },
                'filter' => Html::activeDropDownList($searchModel, 'is_active', [1 => 'Y', 0 => 'N'], ['class'=>'form-control', 'prompt' => '']),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
