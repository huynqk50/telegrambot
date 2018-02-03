<div class="container" id="main">
    <div class="clr wrap news">
        <div class="clr navigation">
            <?= $this->render('//modules/breadcrumb') ?>
        </div>
        <article class="access-block">
            <div class="left">
                <h1 class="title">Đăng ký tài khoản</h1>
                <div class="description">
                    * Vui lòng điền đầy đủ các thông tin sau đây
                </div>
            </div>
            <div class="right">
                <?= $this->render('_form', ['model' => $model]) ?>
            </div>
        </article>
    </div>
</div>