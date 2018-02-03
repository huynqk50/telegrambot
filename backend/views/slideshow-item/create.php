<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SlideshowItem */

$this->title = 'Create Slideshow Item';
$this->params['breadcrumbs'][] = ['label' => 'Slideshow Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slideshow-item-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
