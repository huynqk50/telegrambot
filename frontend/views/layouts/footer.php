<?php

use frontend\models\SiteParam;
use yii\helpers\Url;
use frontend\models\ProductCategory;
use frontend\models\Info;

?>


<section id="partner">
        <div class="container">
            <?php $partner = Info::find()->where(['type' => Info::TYPE_PARTNER])->one();   
             echo $partner == null ? '' : $partner->content ?>
        </div><!--/.container-->
    </section><!--/#partner-->

    <section id="conatcat-info">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <?php $partner = Info::find()->where(['type' => Info::TYPE_CONTACT])->one();   
                    echo $partner == null ? '' : $partner->content ?>
                </div>
            </div>
        </div><!--/.container-->    
    </section><!--/#conatcat-info-->

    <section id="bottom">
        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                <?php $partner = Info::find()->where(['type' => Info::TYPE_BOTTOM_INFO])->one();   
                    echo $partner == null ? '' : $partner->content ?>
            </div>
        </div>
    </section><!--/#bottom-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2017 SpaceV.vn. All Rights Reserved.
                </div>
                <div class="col-sm-6">
                    <ul class="pull-right">
                        <li><a href="/">Home</a></li>
                        <li><a href="<?= Url::to(['site/about'])?>">Giới thiệu</a></li>
                        <li><a href="<?= Url::to(['contact/index'])?>">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->
    <style>
    .fb-msg {
        position: fixed;
        z-index: 9999;
        right: 0.5rem;
        bottom: 0;
    }
    .fb-msg svg {
        display: inline-block;
        vertical-align: middle;
    }
    .fb-toggle {
        padding: 5px 10px;
        border-radius: 5px 5px 0 0;
        background: #3e7cf7;
        font-weight: bold;
        color: #fff;
        cursor: pointer;
    }
    .fb-msg.active {
        bottom: 0;
        height: initial;
    }
    .fb-msg .msg {
        display: none;
    }
    .fb-msg.active .msg {
        display: block;
    }
</style>

    <div class="fb-msg" id="fb-chat">
    <div class="fb-toggle" onclick="document.getElementById('fb-chat').classList.toggle('active')">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="96 93 322 324"><path d="M257 93c-88.918 0-161 67.157-161 150 0 47.205 23.412 89.311 60 116.807V417l54.819-30.273C225.449 390.801 240.948 393 257 393c88.918 0 161-67.157 161-150S345.918 93 257 93zm16 202l-41-44-80 44 88-94 42 44 79-44-88 94z" fill="#FFF"/></svg>
        Chat với chúng tôi
    </div>
    <div class="msg">
        <div class="fb-page"
             data-href="<?php $param = SiteParam::findOneByName(SiteParam::PARAM_FACEBOOK); echo ($param) ? $param->value : ''?>"
             data-small-header="true"
             data-height="300"
             data-width="250"
             data-tabs="messages"
             data-adapt-container-width="false"
             data-hide-cover="true"
             data-show-facepile="false"
             data-show-posts="false">
        </div>
    </div>
</div>
