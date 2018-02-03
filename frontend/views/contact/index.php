<?php

use frontend\models\SiteParam;
use yii\widgets\ActiveForm;

//$p = SiteParam::find()->all();
//var_dump($p);die();
?>


<section id="contact-info">
        <div class="center">                
            <h2>Thông tin liên hệ</h2>
            <!--<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>-->
        </div>
        <div class="gmap-area">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <div class="gmap">
                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php 
                            $map = SiteParam::findOneByName(SiteParam::PARAM_GOOGLE_MAP);
                            echo $map == null ? '' : $map->value?>"></iframe>
                        </div>
                    </div>

                    <div class="col-sm-7 map-content">
                        <ul class="row">
                            <li class="col-sm-offset-3">
                                <address>
                                    <h5>Địa chỉ</h5>
                                    <p><?php ($param = SiteParam::findOneByName(SiteParam::PARAM_ADDRESS)); 
                                            echo $param ? $param->value : ''?></p>
                                    <p>Điện thoại: <?= ($param = SiteParam::findOneByName(SiteParam::PARAM_PHONE_NUMBER)) ? $param->value : ''?> <br>
                                    Email: <?= ($param = SiteParam::findOneByName(SiteParam::PARAM_EMAIL)) ? $param->value : ''?></p>
                                </address>

                                
                            </li>


                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


<section id="contact-page">
        <div class="container">
            <div class="center">        
                <h2>Liên hệ với chúng tôi</h2>
                <!--<p class="lead">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>-->
            </div> 
            <div class="row contact-wrap"> 
                <div class="status alert alert-success" style="display: none"></div>
                <?php $form = ActiveForm::begin(['id' => 'contact-form', 'class' => 'contact-form']); ?>
                <!--<form id="main-contact-form" class="contact-form" name="contact-form" method="post">-->
                    <div class="col-sm-5 col-sm-offset-1">
<!--                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" class="form-control" required="required">
                        </div>-->
                        <?= $form->field($model, 'name', ['options' => ['class' => '']])->textInput() ?>
                        <?= $form->field($model, 'email', ['options' => ['class' => '']])->textInput() ?>
                        <?= $form->field($model, 'mobile', ['options' => ['class' => '']])->textInput() ?>
                                              
                    </div>
                    <div class="col-sm-5">
                        <?= $form->field($model, 'subject', ['options' => ['class' => '']])->textInput() ?>
                        <?= $form->field($model, 'body', ['options' => ['class' => '']])->textArea() ?>
                                             
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Gửi</button>
                        </div>
                    </div>
                <?php ActiveForm::end() ?>
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#contact-page-->
    
    