<?php
use frontend\models\Product;
use frontend\models\UrlParam;
use yii\helpers\Url;
?>
<div class="left">
<section>
    <h2 class="title"><?= $title ?></h2>
    <div class="content product-text grid-view g4 md-g3 sm-g2 aspect-ratio _1x1">
        <div class="content">
            <?=
            $this->render('items', ['models' => $models])
            ?><!--
        No space here
        --></div>
        <?php
        if ($has_more) {
            echo '<button type="button" class="see-more" onclick="seeMore(this.previousElementSibling, this)">Xem thêm</button>';
        }
        ?>
    </div>
</section>
</div>
<?= $this->render('//layouts/aside', ['product_sort' => $product_sort, 'product_attribute_filter' => $product_attribute_filter]) ?>
<script>
    function seeMore(container, button) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                var data = JSON.parse(xhttp.responseText);
                container.innerHTML += data.content;
                if (!data.has_more) {
                    button.parentNode.removeChild(button);
                }
                setObjectOrientation();
                ellipsisTexts();
                formatNumbers();
            }
        };
        xhttp.open("POST", "<?= Url::to(['product/ajax-get-items'], true) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("<?= Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken
        . (isset($category_id) ? '&' . UrlParam::CATEGORY_ID . "=$category_id" : '') ?>");
    }
</script>