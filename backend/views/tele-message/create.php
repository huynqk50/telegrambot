<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TeleMessage */

$this->title = 'Create Tele Message';
$this->params['breadcrumbs'][] = ['label' => 'Tele Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tele-message-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
