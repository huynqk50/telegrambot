<?php
/* @var $this View */

use common\models\User;
use yii\web\View;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="about-us">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Về chúng tôi</h2>
            <div class="lead">				
                <?= $model == null ? '' : $model->content ?>
            </div>              
        </div>

        


        

        <!-- our-team -->
        <div class="team">
            <div class="center wow fadeInDown">
                <h2>Thành viên</h2>
                <!--<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p>-->
            </div>
            
            <div class="row clearfix">
                <?php 
            $mem1 = array_slice($members, 0, 2);
            foreach ($mem1 as $member) { ?>

                <div class="col-md-4 col-sm-6 col-md-offset-2">	
                    <div class="single-profile-top wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="media">
                            <div class="pull-left">
                                <a href="#"><?= $member->img([], User::IMAGE_TINY)?></a>
                            </div>
                            <div class="media-body">
                                <h4><?= $member->lastname . ' '.$member->firstname?></h4>
                                <!--<h5>Founder</h5>-->
                                <ul class="tag clearfix">
                                    <li class="btn"><a href="#">Founder</a></li>
<!--                                    <li class="btn"><a href="#">Ui</a></li>
                                    <li class="btn"><a href="#">Ux</a></li>
                                    <li class="btn"><a href="#">Photoshop</a></li>-->
                                </ul>
                                <ul class="social_icons">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li> 
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div><!--/.media -->
                        <p><?php echo $member->alias ?></p>
                    </div>
                </div><!--/.col-lg-4 -->	
            <?php } ?>
            </div> <!--/.row -->
            <div class="row team-bar">
                <div class="first-one-arrow hidden-xs">
                    <hr>
                </div>
                <div class="first-arrow hidden-xs">
                    <hr> <i class="fa fa-angle-up"></i>
                </div>
                <div class="second-arrow hidden-xs">
                    <hr> <i class="fa fa-angle-down"></i>
                </div>
                <div class="third-arrow hidden-xs">
                    <hr> <i class="fa fa-angle-up"></i>
                </div>
                <div class="fourth-arrow hidden-xs">
                    <hr> <i class="fa fa-angle-down"></i>
                </div>
            </div> <!--skill_border-->       

            <div class="row clearfix">   
                <?php 
            $mem1 = array_slice($members, 2, 2);
            foreach ($mem1 as $member) { ?>
                <div class="col-md-4 col-sm-6 col-md-offset-2">	
                    <div class="single-profile-top wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="media">
                            <div class="pull-left">
                                <a href="#"><?= $member->img([], User::IMAGE_TINY)?></a>
                            </div>
                            <div class="media-body">
                                <h4><?= $member->lastname . ' '.$member->firstname?></h4>
                                <!--<h5>Founder</h5>-->
                                <ul class="tag clearfix">
                                    <li class="btn"><a href="#">Founder</a></li>
<!--                                    <li class="btn"><a href="#">Ui</a></li>
                                    <li class="btn"><a href="#">Ux</a></li>
                                    <li class="btn"><a href="#">Photoshop</a></li>-->
                                </ul>
                                <ul class="social_icons">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li> 
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div><!--/.media -->
                        <p><?php echo $member->alias ?></p>
                    </div>
                </div><!--/.col-lg-4 -->
            <?php } ?>
            </div>	<!--/.row-->
        </div><!--section-->
    </div><!--/.container-->
</section><!--/about-us-->