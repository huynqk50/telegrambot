<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Video */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
