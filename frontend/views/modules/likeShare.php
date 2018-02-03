<div class="like-share <?= !empty($class) ? $class : '' ?>">
    <div class="item">    
        <g:plusone size="medium" data-href="<?= \yii\helpers\Url::current([], true) ?>"></g:plusone>
    </div>
    <div class="item">
        <div class="fb-like" size="small" data-share="true" data-layout="button_count" data-count="true" data-href="<?= $this->context->link_canonical; ?>"></div>
    </div> 
    <div class="clearfix"></div>
</div>
<?php

$this->registerCss(
".like-share .item{float:left;line-height:0;}
.like-share .item:first-child{max-width:5em;}
");