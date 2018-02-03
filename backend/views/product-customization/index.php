<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductCustomizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Customizations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-customization-index">
<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Customization', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'productOptions',
                'format' => 'raw',
                'value' => function ($model) {
                    $list = '';
                    $i = 0;
                    foreach ($model->productOptions as $option) {
                        if ($i++ > 0) {
                            $list .= ' ; ';
                        }
                        $list .= $option->name;
                    }
                    return $list;
                }
            ],
            'price',
            'original_price',
            'order_quantity',
            'sold_quantity',
            'available_quantity',
            'total_quantity',
            'total_revenue',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
