<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SeoInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Thông tin SEO';
$this->params['breadcrumbs'][] = $this->title;

yii\helpers\Url::remember();
?>
<div class="seo-info-index">

<!--    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Seo Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img($model->getImage(), ['style'=>'max-height:100px;max-width:100px']);
                },
            ],
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->url, $model->url, ['style'=>'color:#04a', 'target' => '_blank']);
                },
            ],
//            'type',
            'page_title',
//            'meta_title',
            // 'meta_keywords',
            // 'meta_description',
            // 'long_description:ntext',
//             'h1',
            // 'image_path',
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return date('Y-m-d H:i', $model->created_at);
                },
            ],
            // 'updated_at',
             'created_by',
            // 'updated_by',                        
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_active === 1 ? Html::tag('span', 'Ok', ['class' => 'label label-info']) : Html::tag('span', '<span class="fa fa-close"></span>', ['class' => 'label label-danger']);
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
