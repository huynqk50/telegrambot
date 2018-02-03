<?php
use frontend\models\Article;

foreach ($models as $item) {
    echo "<li>{$item->a(['class' => 'clr'],
        '<div class="image"><div class="item-view"><div class="img-wrap">'
        . $item->img([], isset($image_size) ? $image_size : null) . '</div>'
//        . '<div class="caption">' . $item->name . '</div>'
        . '</div></div>'
        . '<h3 class="name">' . $item->name . '</h3>'
//        . '<div class="info">'
//            . '<em><i class="icon calendar-icon"></i> <span class="time-ago">' . $item->published_at . '</span></em>'
//            . ' | <em><i class="icon comment-icon"></i> <span class="number-kmb">' . $item->comment_count . '</span></em>'
//            . ' | <em><i class="icon view-icon"></i> <span class="number-kmb">' . $item->view_count . '</span></em>'
//        . '</div>'
//        . '<div class="intro">' . $item->description . '</div>'
    )}</li>";
}