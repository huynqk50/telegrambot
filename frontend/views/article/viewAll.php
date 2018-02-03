<?php

use frontend\models\Article;
use frontend\models\UrlParam;
use yii\helpers\Url;

?>
<section id="blog" class="container">
        <div class="center">
            <h2><?= $title ?></h2>
            <p class="lead"><?= $category->description ?></p>
        </div>
        <div class="blog">
            <div class="row">
                 <div class="col-md-8">
                <?=
                $this->render('items', ['models' => $models, 'image_size' => Article::IMAGE_HUGE])
                ?><!--
            No space here
                --></div>
            <?= $this->render('//layouts/aside');?>
            </div></div>
            <?php
            if ($has_more) {
                echo '<button type="button" class="see-more" onclick="seeMore(this.previousElementSibling, this)">Xem thêm</button>';
            }
            ?>
        </div>
    </section>
<?php // echo $this->render('//layouts/aside') ?>
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
        xhttp.open("POST", "<?= Url::to(['article/ajax-get-items'], true) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("<?= Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken
        . (isset($category_id) ? '&' . UrlParam::CATEGORY_ID . "=$category_id" : '') ?>");
    }
</script>