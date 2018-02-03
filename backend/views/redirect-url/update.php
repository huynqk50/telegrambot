<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\RedirectUrl */

$this->title = 'Update Redirect Url: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Redirect Urls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="redirect-url-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
