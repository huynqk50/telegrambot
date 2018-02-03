<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<meta charset="utf-8">
<meta http-equiv="content-language" content="vi">
<title><?= $this->context->page_title ?></title>
<meta name="description" content="<?= $this->context->meta_description ?>">
<meta name="keywords" content="<?= $this->context->meta_keywords ?>">
<meta name="robots" content="<?= $this->context->meta_index ?>, <?= $this->context->meta_follow ?>">
<meta name="robots" content="NOODP, NOYDIR">
<meta name="p:domain_verify" content="f499ac4524c7ccfc7064d9c38774e229">
<meta name="geo.region" content="VN-HN">
<meta name="geo.placename" content="Hà Nội">
<meta name="geo.position" content="21.033953;105.785002">
<meta name="ICBM" content="21.033953, 105.785002">
<meta name="DC.Source" content="<?= Url::home(true) ?>">
<meta name="DC.Coverage" content="Vietnam">
<meta name="RATING" content="GENERAL">
<meta name="COPYRIGHT" content="<?= Yii::$app->name ?>">
<meta property="fb:app_id" content="<?= Yii::$app->params['fb_app_id'] ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?= $this->context->meta_title ?>">
<meta property="og:description" content="<?= $this->context->meta_description ?>">
<meta property="og:url" content="<?= $this->context->link_canonical ?>">
<meta property="og:image" content="<?= $this->context->meta_image ?>">
<meta property="og:site_name" content="<?= Yii::$app->name ?>">
<meta property="article:publisher" content="">
<link rel="canonical" href="<?= $this->context->link_canonical ?>">
<link rel="image_src" type="image/jpeg" href="<?= $this->context->meta_image ?>">
<link rel="alternate" media="handheld" href="<?= $this->context->link_canonical ?>">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<!-- Chrome for Android theme color -->
<meta name="theme-color" content="#00BECC">
<meta name="REVISIT-AFTER" content="1 DAYS">
<meta name="google-site-verification" content="NdAaFvG8fhJaOzAlC1z26OEXxDgrx7hFpY1r0G_XeOw" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, shrink-to-fit=no">
<?= Html::csrfMetaTags() ?>