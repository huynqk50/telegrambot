<div class="container" id="main">
    <div class="clr wrap news">
        <div class="clr navigation">
            <?= $this->render('//modules/breadcrumb') ?>
        </div>
        <article>
            <!--<h1 class="title"><?= $model->name ?></h1>-->
            <div class="fit-content">
                <?= $model->content ?>
            </div>
        </article>
    </div>
</div>