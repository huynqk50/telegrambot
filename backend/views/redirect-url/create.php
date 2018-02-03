<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\RedirectUrl */

$this->title = 'Create Redirect Url';
$this->params['breadcrumbs'][] = ['label' => 'Redirect Urls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redirect-url-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
