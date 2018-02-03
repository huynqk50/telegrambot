<?php

//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;


use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
//use yii\helpers\Url;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
<?php require_once('css.php') ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">
<?php require_once 'top.php'; ?>
<?php require_once 'left.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php if($content){  ?>
    <!-- Main content -->
    <section class="content" id="mainContent">
        <!-- Main row -->
        <div class="box box-solid" style="opacity:0.95">
            <?php 
            
            if (!empty($this->context->product_id)) {
                $product_id = $this->context->product_id;
                $menuItems = [
                    ['label' => 'Sản phẩm', 'url' => ['product/update', 'id' => $product_id]],
                    ['label' => 'DS lựa chọn', 'url' => ['product-customization/index', 'product_id' => $product_id]],
                    ['label' => 'Thêm lựa chọn', 'url' => ['product-customization/create', 'product_id' => $product_id]],
                ];
            }

            if (in_array(Yii::$app->controller->id, ['purchase-order', 'purchase-order-detail'])) {
                $menuItems = [
                    ['label' => 'Danh sách đơn hàng', 'url' => ['purchase-order/index']],
                ];
            }

            if (!empty($this->context->purchase_order_id)) {
                $purchase_order_id = $this->context->purchase_order_id;
                $menuItems = [
                    ['label' => 'Thông tin đơn hàng', 'url' => ['purchase-order/update', 'id' => $purchase_order_id]],
                    ['label' => 'Chi tiết đơn hàng', 'url' => ['purchase-order-detail/index', 'purchase_order_id' => $purchase_order_id]],
                ];
            }

            if (in_array(Yii::$app->controller->id, ['admin', 'site', 'user-log'])) {
                $menuItems = [
                ];
            }

            isset($menuItems) or $menuItems = [
                ['label' => 'Danh sách', 'url' => [Yii::$app->controller->id . '/index']],
                ['label' => 'Thêm mới', 'url' => [Yii::$app->controller->id . '/create']],
            ];
            
            if (!empty($menuItems)) {
                NavBar::begin([
                    'options' => [
                        'class' => 'nav',
                        'role' => 'presentation'
                    ],
                    'innerContainerOptions' => [
                        'class' => 'box-header',
                    ],
                ]);
                echo Nav::widget([
                    'options' => ['class' => 'nav nav-tabs'],
                    'items' => $menuItems,
                ]);
                NavBar::end();
            }
            
            ?>            
            <div class="box-body">
                <?= $content ?>
            </div>
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
    <?php } ?>
</div><!-- /.content-wrapper -->
<?php require_once 'footer.php'; ?>
</div>
<?php require_once 'js.php'; ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
