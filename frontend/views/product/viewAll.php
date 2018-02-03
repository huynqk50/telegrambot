<?php
use frontend\models\Product;
?>
<div class="left">
    <?php
    foreach ($product_cats as $category) {
        if ($category->parent_id) {
            continue;
        }
        ?>
        <section>
            <?= $category->a(['class' => 'title'], $category->label ? $category->label : $category->name) ?>
            <div class="content product-text grid-view g4 md-g3 sm-g2 aspect-ratio _1x1">
                <div class="content">
                    <?php
                    foreach ($category->getAllProducts()
                                 ->orderBy('is_hot desc, published_at desc')
                                 ->limit(10)->allPublished() as $item) {
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
                </div>
            </div>
        </section>
        <?php
    }
    ?>
</div>
<?= $this->render('//layouts/aside') ?>