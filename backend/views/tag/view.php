<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Tag */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-view">

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
            'page_title',
            'h1',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'description',
            'sort_order',
            'long_description:ntext',
            'image',
            'image_path',
            'is_active',
            'is_hot',
            'status',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'type',
        ],
    ]) ?>

</div>
