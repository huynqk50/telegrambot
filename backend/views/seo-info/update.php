<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SeoInfo */

$this->title = 'Cập nhật thông tin SEO: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Thông tin SEO', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seo-info-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
