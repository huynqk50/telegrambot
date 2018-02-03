<?php
use frontend\models\Product;

foreach ($models as $item) {
    echo $item->a(['class' => 'item'],
        "<div class=\"image item-view\">
            <div class=\"img-wrap\">
                {$item->img([], Product::IMAGE_SMALL)}
            </div>
        </div>
        <div class=\"desc\">
            <h3 class=\"name\">$item->name</h3>
            <div class=\"price\">
                <b class=\"sale short-vnd\">$item->price</b>
                " . ($item->hasDiscount() ? "<b class=\"origin short-vnd\">{$item->original_price}</b>" : '') . "
            </div>
        </div>"
        . ($item->hasDiscount() ? "<div class=\"sticky\">&minus;{$item->discountPercent()}%</div>" : '')
    );
}
?>