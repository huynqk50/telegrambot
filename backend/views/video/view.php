<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Video */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-view">

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
            'category_id',
            'name',
            'label',
            'slug',
            'old_slugs',
            'description',
            'image',
            'image_path',
            'page_title',
            'meta_title',
            'meta_keywords',
            'meta_description',
            'h1',
            'long_description:ntext',
            'source',
            'view_count',
            'like_count',
            'comment_count',
            'share_count',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'published_at',
            'auth_alias',
            'is_hot',
            'is_active',
            'sort_order',
            'status',
            'type',
        ],
    ]) ?>

</div>
