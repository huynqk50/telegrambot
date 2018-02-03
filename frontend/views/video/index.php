<?php
use frontend\models\Article;
?>
<div class="left clr news-page">
    <div class="left">
        <section class="news news-text">
            <h2 class="name"><?= $model->name ?></h2>
            <div class="info">
                <em><span class="date-time"><?= $model->published_at ?></span></em>
                | <em><span class="icon comment-icon"></span> <?= $model->comment_count ?> bình luận</em>
                | <em><span class="icon view-icon"></span> <span class="number-kmb"><?= $model->view_count ?></span> xem</em>
            </div>
            <div class="content item-view aspect-ratio _16x9">
                <div class="img-wrap">
                    <iframe frameborder="0" allowfullscreen src="<?= $model->source ?>"></iframe>
                </div>
            </div>
            <div class="author">
                Theo: <?= $model->auth() ?>
            </div>
        </section>
        <section class="hot-news">
            <div class="title">Video cùng chuyên mục</div>
            <div class="content clr news-text details-view d41 aspect-ratio _16x9">
                <?php
                $li = function ($item) {
                    return "<li>{$item->a(['class' => 'clr'],
                        '<div class="image"><div class="item-view"><div class="img-wrap">'
                        . $item->img([], Article::IMAGE_SMALL) . '</div></div></div>'
                        . '<h3 class="name">' . $item->name . '</h3>'
                        )}</li>";
                };
                ?>
                <ul class="left">
                <?php
                for ($i = 0; $i < 10; $i+=2) {
                    if (isset($hot_items[$i])) {
                        echo $li($hot_items[$i]);
                    }
                }
                ?>
                </ul>
                <ul class="right">
                <?php
                for ($i = 1; $i < 10; $i+=2) {
                    if (isset($hot_items[$i])) {
                        echo $li($hot_items[$i]);
                    }
                }
                ?>
                </ul>
            </div>
        </section>
        <section>
            <?= $this->render('//modules/comment') ?>
        </section>
    </div>
    <div class="right">
        <div class="rel-news">
            <div class="title"><strong>Video khác</strong></div>
            <ul>
                <?php
                $i = 0;
                foreach (array_slice($related_items, 0, 5) as $item) {
                    $i++;
                    echo '<li>';
                    if ($i == 1) {
                        echo "<div class=\"image\"><div class=\"item-view aspect-ratio _16x9\"><div class=\"img-wrap\">{$item->img()}</div></div></div>";
                    }
                    echo $item->a() . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<?= $this->render('//layouts/aside') ?>