<div class="container" id="main">
    <div class="clr wrap news">
        <div class="clr navigation">
            <?= $this->render('//modules/breadcrumb') ?>
        </div>
        <article class="access-block">
            <div class="left">
                <h1 class="title">Thay đổi thông tin cá nhân</h1>
            </div>
            <div class="right">
                <?= $this->render('_form_1', ['model' => $model]) ?>
            </div>
        </article>
    </div>
</div>