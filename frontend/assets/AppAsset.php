<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/animate.min.css',
        'css/prettyPhoto.css',
        'css/main.css',
        'css/responsive.css',
        
    ];
    
    public $js = [
        'js/jquery.js',
        'js/bootstrap.min.js',
        'js/jquery.prettyPhoto.js',
        'js/jquery.isotope.min.js',
        'js/main.js',
        'js/wow.min.js',
    ];
    
    public $depends = [

    ];
}
