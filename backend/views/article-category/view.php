<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Article Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'label',
            'slug',
            'old_slugs',
            'parent_id',
            'description',
            'long_description:ntext',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'h1',
            'page_title',
            'image',
            'banner',
            'image_path',
            'status',
            'is_hot',
            'sort_order',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'is_active',
            'type',
        ],
    ]) ?>

</div>
