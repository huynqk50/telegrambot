<?php

use backend\models\ArticleCategorySearch;
use backend\models\ArticleCategory;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ArticleCategorySearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Article Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article Category', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'parent_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->parent ? $model->parent->name : '';
                },
                'filter' => Html::activeDropDownList($searchModel, 'parent_id', ArticleCategory::listNoArticle(), ['class'=>'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_active === 1 ? Html::tag('span', 'Ok', ['class' => 'label label-info']) : Html::tag('span', '<span class="fa fa-close"></span>', ['class' => 'label label-danger']);
                },
                'filter' => Html::activeDropDownList($searchModel, 'is_active', [1 => 'Y', 0 => 'N'], ['class'=>'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'is_hot',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_hot === 1 ? Html::tag('span', 'Hot', ['class' => 'label label-warning']) : Html::tag('span', '<span class="fa fa-close"></span>', ['class' => 'label label-default']);
                },
                'filter' => Html::activeDropDownList($searchModel, 'is_hot', [1 => 'Y', 0 => 'N'], ['class'=>'form-control', 'prompt' => '']),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
