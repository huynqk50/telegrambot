<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SiteParamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Site Params';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-param-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Site Param', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    if (isset(backend\models\SiteParam::$params[$model->name])) {
                        return backend\models\SiteParam::$params[$model->name];
                    } else {
                        return $model->name;
                    }
                }
            ],
            'value',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
