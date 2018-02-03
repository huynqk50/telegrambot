<?php
use frontend\models\Article;

foreach ($models as $item) { ?>
<div class='blog-item'>
    <div class="col-xs-12 col-sm-2 text-center">
        <div class="entry-meta">
                                    <span id="publish_date" ><?= date('d/m/Y', $item->published_at)?></span>
                                    <span><i class="fa fa-user"></i> <a href="#"><?= $item->auth_alias == '' ? 'Admin' : $item->auth_alias?></a></span>
                                    <span><i class="fa fa-comment"></i> <a href="#"><?= $item->comment_count?> Comments</a></span>
                                    <!--<span><i class="fa fa-heart"></i><a href="#">56 Likes</a></span>-->
                                </div>
                            </div>
    <div class="col-xs-12 col-sm-10 blog-content">
                                <a href="<?= $item->getLink()?>"><?= $item->img(["class"=>"img-responsive img-blog", 'width' => '100%'], isset($image_size) ? $image_size : null)?></a>
                                <h2><a href="<?= $item->getLink()?>"><?= $item->name?></a></h2>
                                <h3><?= $item->description?></h3>
                                <a class="btn btn-primary readmore" href="<?= $item->getLink()?>">Chi tiết <i class="fa fa-angle-right"></i></a>
                            </div>

    </div>
<?php }
