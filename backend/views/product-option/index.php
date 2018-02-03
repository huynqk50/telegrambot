<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\ProductOptionGroup;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductOptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Options';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-option-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Option', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'group',
                'value' => 'group.name',
                'filter' => Html::activeDropDownList($searchModel, 'group_id', ArrayHelper::map(ProductOptionGroup::find()->asArray()->all(), 'id', 'name'), ['class'=>'form-control', 'prompt' => '']),
            ],
            'sort_order',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
