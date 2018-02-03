<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductCustomization */

$this->title = 'Create Product Customization';
$this->params['breadcrumbs'][] = ['label' => 'Product Customizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-customization-create">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'username' => $username,
        'model' => $model,
    ]) ?>

</div>
