<?php

use frontend\models\Article;

$hotArticles = Article::find()->where(['status' => Article::STATUS_HOT])->limit(4)->allPublished();
?>
<aside class="col-md-4">
<!--                    <div class="widget search">
                        <form role="form">
                                <input type="text" class="form-control search_box" autocomplete="off" placeholder="Search Here">
                        </form>
                    </div>/.search-->
    				
    				<div class="widget categories">
                        <h3>Bài viết nổi bật</h3>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php foreach ($hotArticles as $item) { ?>
                                <div class="single_comments">
                                    <?= $item->img([], Article::IMAGE_VERY_TINY)?>
                                    <h4><a href="<?= $item->getLink()?>"><?= $item->name?></a></h4>
                                    <p><?= $item->description?></p>
                                    <div class="entry-meta small muted">
                                        <span>By <a href="#"><?= $item->auth_alias == '' ? 'Admin' : $item->auth_alias?></a></span>
                                    </div>
                                </div>
                                <?php } ?>
                                
                            </div>
                        </div>                     
                    </div><!--/.recent comments-->
                     

<!--                    <div class="widget categories">
                        <h3>Categories</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="blog_category">
                                    <li><a href="#">Computers <span class="badge">04</span></a></li>
                                    <li><a href="#">Smartphone <span class="badge">10</span></a></li>
                                    <li><a href="#">Gedgets <span class="badge">06</span></a></li>
                                    <li><a href="#">Technology <span class="badge">25</span></a></li>
                                </ul>
                            </div>
                        </div>                     
                    </div>/.categories-->
    				
<!--    				<div class="widget archieve">
                        <h3>Archieve</h3>
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="blog_archieve">
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> December 2013 <span class="pull-right">(97)</span></a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> November 2013 <span class="pull-right">(32)</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> October 2013 <span class="pull-right">(19)</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> September 2013 <span class="pull-right">(08)</a></li>
                                </ul>
                            </div>
                        </div>                     
                    </div>/.archieve-->
    				
                    <div class="widget tags">
                        <h3>Tags</h3>
                        <ul class="tag-cloud">
<!--                            <li><a class="btn btn-xs btn-primary" href="#">Apple</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Barcelona</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Office</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Ipod</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Stock</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Race</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">London</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Football</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Porche</a></li>
                            <li><a class="btn btn-xs btn-primary" href="#">Gadgets</a></li>-->
                        </ul>
                    </div><!--/.tags-->
    				
<!--    				<div class="widget blog_gallery">
                        <h3>Our Gallery</h3>
                        <ul class="sidebar-gallery">
                            <li><a href="#"><img src="images/blog/gallery1.png" alt="" /></a></li>
                            <li><a href="#"><img src="images/blog/gallery2.png" alt="" /></a></li>
                            <li><a href="#"><img src="images/blog/gallery3.png" alt="" /></a></li>
                            <li><a href="#"><img src="images/blog/gallery4.png" alt="" /></a></li>
                            <li><a href="#"><img src="images/blog/gallery5.png" alt="" /></a></li>
                            <li><a href="#"><img src="images/blog/gallery6.png" alt="" /></a></li>
                        </ul>
                    </div>/.blog_gallery-->
    			</aside>