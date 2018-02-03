<?php
/* @var $this View */

use common\models\User;
use yii\web\View;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="feature" class="transparent-bg">
        <div class="container">
       <?= $model == null ? '' : $model->content ?>
    </div><!--/.container-->
</section><!--/about-us-->