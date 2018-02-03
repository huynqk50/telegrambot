<?php

use frontend\controllers\PurchaseOrderController;
use frontend\models\Menu;
use frontend\models\SiteParam;
use yii\helpers\Url;

$menu = Menu::getTopParents();
$cart = Yii::$app->session->get(PurchaseOrderController::CART_KEY, []);
$cart_count = count($cart);
?>
<header id="header">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="top-number"><p><i class="fa fa-phone-square"></i><?= ($p = SiteParam::findOneByName(SiteParam::PARAM_PHONE_NUMBER)) ? "$p->value" : 'javascript:;'?></p></div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                       <div class="social">
                            <ul class="social-share">
                                <li><a href="<?= SiteParam::findOneByName(SiteParam::PARAM_FACEBOOK)->value?>"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="<?= SiteParam::findOneByName(SiteParam::PARAM_TWITTER)->value?>"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="<?= SiteParam::findOneByName(SiteParam::PARAM_LINKED_IN)->value?>"><i class="fa fa-linkedin"></i></a></li> 
                                <li><a href="<?= SiteParam::findOneByName(SiteParam::PARAM_DRIBBBLE)->value?>"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="<?= SiteParam::findOneByName(SiteParam::PARAM_SKYPE)->value?>"><i class="fa fa-skype"></i></a></li>
                            </ul>
<!--                            <div class="search">
                                <form role="form">
                                    <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                                    <i class="fa fa-search"></i>
                                </form>
                           </div>-->
                       </div>
                    </div>
                </div>
            </div><!--/.container-->
        </div><!--/.top-bar-->

        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= Url::home(true) ?>"><img src="images/logo.png" alt="logo"></a>
                </div>
				
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                         <?php
                foreach ($menu as $item) {
                    $children = $item->getChildren();
                    ?>
                    <li class="<?= $item->isCurrent() ? ' active' : '' ?> <?= empty($children) ? '' : ' dropdown'  ?>">
                      <?php  echo $item->a();
                      if (empty($children)) { ?>
                        <ul class="dropdown-menu">
                            <?php
                                foreach ($children as $child) {
                                    ?>
                                    <li<?= $child->isCurrent() ? ' class="active"' : '' ?>>
                                        <?= $child->a() ?>
                                    </li>
                                    <?php
                                }
                                ?>
                        </ul>
                      <?php } ?>
<!--                        <li class="active"><a href="index.html">Home</a></li>
                        <li><a href="about-us.html">About Us</a></li>
                        <li><a href="services.html">Services</a></li>
                        <li><a href="portfolio.html">Portfolio</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="blog-item.html">Blog Single</a></li>
                                <li><a href="pricing.html">Pricing</a></li>
                                <li><a href="404.html">404</a></li>
                                <li><a href="shortcodes.html">Shortcodes</a></li>
                            </ul>
                        </li>
                        <li><a href="blog.html">Blog</a></li> 
                        <li><a href="contact-us.html">Contact</a></li>  -->
                <?php } ?>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
		
    </header><!--/header-->