<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SeoInfo */

$this->title = 'Thêm mới thông tin SEO';
$this->params['breadcrumbs'][] = ['label' => 'Thông tin SEO', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-info-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
