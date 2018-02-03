<?php

use frontend\models\SlideshowItem;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$slideshows = SlideshowItem::find()->allActive();
$i = 0;
?>
<section id="main-slider" class="no-margin">
        <div class="carousel slide">
            <ol class="carousel-indicators">
                <?php foreach ($slideshows as $model) { ?>
                <li data-target="#main-slider" data-slide-to="<?= $i++?>" class="<?= $i == 1 ? 'active':''?>"></li>
                <?php } ?>
            </ol>
            <div class="carousel-inner">
                <?php 
                $i = 0;
                foreach ($slideshows as $model) { 
                    $captionArr = explode("\n", trim($model->caption));
                    ?>
                <div class="item <?= $i++ ==0 ? 'active' : ''?>" style="background-image: url(<?= $model->getImage(SlideshowItem::IMAGE_HUGE)?>)">
                    <div class="container">
                        <div class="row slide-margin">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1"><?= isset($captionArr[0]) ? $captionArr[0] : ''?></h1>
                                    <h2 class="animation animated-item-2"><?= isset($captionArr[1]) ? $captionArr[1] : ''?></h2>
                                    <?php if($model->link != '') {?><a class="btn-slide animation animated-item-3" href="<?= $model->link?>">Chi tiết</a><?php } ?>
                                </div>
                            </div>

<!--                            <div class="col-sm-6 hidden-xs animation animated-item-4">
                                <div class="slider-img">
                                    <img src="images/slider/img1.png" class="img-responsive">
                                </div>
                            </div>-->

                        </div>
                    </div>
                </div><!--/.item-->
                <?php } ?>
                
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
    </section><!--/#main-slider-->