<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Logs';
$this->params['breadcrumbs'][] = $this->title;

yii\helpers\Url::remember();
?>
<div class="user-log-index">

<!--    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'username',
            'action',
            'object_class',
            'object_pk',
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return date('Y-m-d H:i', $model->created_at);
                },
            ],
            [
                'attribute' => 'is_success',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_success === 1 ? Html::tag('span', 'Success', ['class' => 'label label-info']) : Html::tag('span', 'Fail', ['class' => 'label label-danger']);
                },
            ],

//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template' => '{delete}'
//            ],
        ],
    ]); ?>

</div>
