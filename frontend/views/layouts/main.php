<?php

/* @var $this View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\web\View;

AppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" itemscope itemtype="http://schema.org/WebPage">
<head>
<?php
require_once 'meta.php';
$this->head();
?>
</head>
<body class="homepage">
<?php
$this->beginBody();
//require_once 'header.php';
if (!in_array(Yii::$app->controller->id, ['site'])) {
//    echo $this->render('//modules/breadcrumb');
}
?>

        <?= $content ?>

<?php
//require_once 'footer.php';
$this->endBody();
//require_once 'js.php';
?>
</body>
</html>
<?php
$this->endPage();
