<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TeleUser */

$this->title = 'Create Tele User';
$this->params['breadcrumbs'][] = ['label' => 'Tele Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tele-user-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
