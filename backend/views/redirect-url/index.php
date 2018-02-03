<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RedirectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Redirects';
$this->params['breadcrumbs'][] = $this->title;

yii\helpers\Url::remember();
?>
<div class="redirect-index">

<!--    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Redirect', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'from_urls:ntext',
            [
                'attribute' => 'from_urls',
                'format' => 'raw',
                'value' => function ($model) {
                    $from_urls_arr = json_decode($model->from_urls);
                    is_array($from_urls_arr) or $from_urls_arr = array();
                    foreach ($from_urls_arr as &$url) {
                        $url = Html::a($url, $url, ['target' => '_blank', 'style' => 'color:#e06400']);
//                        $url = Html::a($url, $url, ['target' => '_blank', 'style' => 'color:#429']);
                    }
                    return implode("<hr style='margin:4px 0'>", $from_urls_arr);
                },
            ],
            [
                'attribute' => 'to_url',
                'format' => 'raw',
//                'options' => ['style' => 'color:red'],
                'value' => function ($model) {
                    return Html::a($model->to_url, $model->to_url, ['target' => '_blank', 'style' => 'color:#04a']);
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return date('Y-m-d H:i', $model->created_at);
                },
            ],
            'created_by',
            // 'updated_by',
            // 'updated_at',
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_active === 1 ? Html::tag('span', 'Ok', ['class' => 'label label-success']) : Html::tag('span', '<span class="fa fa-close"></span>', ['class' => 'label label-danger']);
                },
            ],
            // 'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
