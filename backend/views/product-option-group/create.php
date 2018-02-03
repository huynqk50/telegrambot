<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductOptionGroup */

$this->title = 'Create Product Option Group';
$this->params['breadcrumbs'][] = ['label' => 'Product Option Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-option-group-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
