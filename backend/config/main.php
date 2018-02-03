<?php
use frontend\controllers\SitemapController;
use frontend\models\UrlParam;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'name' => 'SpaceV',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log',
        'gii'
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => '@app/views/layouts/main.php',
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [ //here
                'model' => [ // generator name
                    'class' => 'common\gii\generators\model\Generator', // generator class
                    'templates' => [ //setting for out templates
                        'custom' => __DIR__ . '/../../common/gii/generators\model/default', // template name => path to template
                    ]
                ],
                'crud' => [ // generator name
                    'class' => 'common\gii\generators\crud\Generator', // generator class
                    'templates' => [ //setting for out templates
                        'custom' => __DIR__ . '/../../common/gii/generators\crud/default', // template name => path to template
                    ]
                ]
            ],
        ]         
    ],
    'components' => [
        // http://www.yiiframework.com/doc-2.0/guide-tutorial-shared-hosting.html
//        'request' => [
//            'baseUrl' => '/backend',
//            'csrfParam' => '_backendCSRF',
//            'csrfCookie' => [
//                'path' => '/backend',
//                'httpOnly' => true,
//            ],
//        ],
//        'session' => [
//            'name' => 'BACKENDSESSID',
//            'cookieParams' => [
//                'path' => '/backend',
//            ],
//        ],
//        'user' => [
//            'identityClass' => 'backend\models\User',
//            'enableAutoLogin' => true,
//            'identityCookie' => [
//                'name' => '_backendIdentity',
//                'path' => '/backend',
//                'httpOnly' => true,
//            ],
//        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'frontendUrlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // Home
                ['pattern' => '', 'route' => 'site/index'],
                ['pattern' => '/', 'route' => 'site/index'],
                //
                ['pattern' => 'cua-hang.html', 'route' => 'store/index'],
                ['pattern' => 'test', 'route' => 'test/index'],
                // Contact
                ['pattern' => 'contact/create-with-email', 'route' => 'contact/create-with-email'],
                ['pattern' => 'contact/ajax-create', 'route' => 'contact/ajax-create'],
                ['pattern' => 'lien-he.html', 'route' => 'contact/index'],
                // Purchase order
                ['pattern' => 'purchase-order/ajax-create', 'route' => 'purchase-order/ajax-create'],
                ['pattern' => 'purchase-order/add-to-cart', 'route' => 'purchase-order/add-to-cart'],
                ['pattern' => 'purchase-order/remove-from-cart', 'route' => 'purchase-order/remove-from-cart'],
                ['pattern' => 'purchase-order/update-cart-data', 'route' => 'purchase-order/update-cart-data'],
                ['pattern' => 'gio-hang.html', 'route' => 'purchase-order/cart-checkout'],
                ['pattern' => 'dat-hang-thanh-cong.html', 'route' => 'purchase-order/review-checklist'],
                // Sitemap
                ['pattern' => 'sitemap.xml', 'route' => 'sitemap/view-all'],
                ['pattern' => 'sitemap-<' . UrlParam::ALIAS . ':(' . SitemapController::ALIAS_ARTICLE . '|' . SitemapController::ALIAS_PRODUCT . ')>-<' . UrlParam::SLUG . '>.xml', 'route' => 'sitemap/index'],
                // Customer
                ['pattern' => 'u/dang-nhap.html', 'route' => 'site/login'],
                ['pattern' => 'u/dang-xuat.html', 'route' => 'site/logout'],
                ['pattern' => 'u/dang-ky.html', 'route' => 'customer/create'],
                ['pattern' => 'u/quen-mat-khau.html', 'route' => 'site/request-password-reset'],
                ['pattern' => 'u/yeu-cau-kich-hoat-tai-khoan.html', 'route' => 'site/request-account-activation'],
                ['pattern' => 'u/dat-lai-mat-khau-<' . UrlParam::TOKEN . '>.html', 'route' => 'site/reset-password'],
                ['pattern' => 'u/kich-hoat-tai-khoan-<' . UrlParam::TOKEN . '>.html', 'route' => 'site/activate-account'],
                ['pattern' => 'u/thay-doi-thong-tin-ca-nhan.html', 'route' => 'customer/update'],
                ['pattern' => 'u/thay-doi-mat-khau.html', 'route' => 'customer/update-password'],
                ['pattern' => 'u/<' . UrlParam::USERNAME . '>', 'route' => 'customer/index'],
                ['pattern' => 'u/<' . UrlParam::USERNAME . '>', 'route' => 'customer/index', 'suffix' => '/'],
                // Info
                ['pattern' => '<' . UrlParam::SLUG . '>.html', 'route' => 'info/index'],
                // Article
                ['pattern' => 'article/counter', 'route' => 'article/counter'],
                ['pattern' => 'article/ajax-get-items', 'route' => 'article/ajax-get-items'],
                ['pattern' => 'tin-tuc', 'route' => 'article/view-all'],
                ['pattern' => 'tin-tuc/', 'route' => 'article/view-all'],
                ['pattern' => 'tin-tuc/<' . UrlParam::PARENT_SLUG . '>/<' . UrlParam::CATEGORY_SLUG . '>/<' . UrlParam::SLUG . '>.html', 'route' => 'article/index'],
                ['pattern' => 'tin-tuc/<' . UrlParam::CATEGORY_SLUG . '>/<' . UrlParam::SLUG . '>.html', 'route' => 'article/index'],
                ['pattern' => 'tin-tuc/<' . UrlParam::SLUG . '>.html', 'route' => 'article/index'],
                // Article Category
                ['pattern' => 'tin-tuc/<' . UrlParam::PARENT_SLUG . '>/<' . UrlParam::SLUG . '>', 'route' => 'article/category'],
                ['pattern' => 'tin-tuc/<' . UrlParam::PARENT_SLUG . '>/<' . UrlParam::SLUG . '>/', 'route' => 'article/category'],
                ['pattern' => 'tin-tuc/<' . UrlParam::SLUG . '>', 'route' => 'article/category'],
                ['pattern' => 'tin-tuc/<' . UrlParam::SLUG . '>/', 'route' => 'article/category'],
                // Product
                ['pattern' => 'product/counter', 'route' => 'product/counter'],
                ['pattern' => 'product/ajax-get-items', 'route' => 'product/ajax-get-items'],
//                ['pattern' => 'san-pham', 'route' => 'product/view-all'],
//                ['pattern' => 'san-pham/', 'route' => 'product/view-all'],
                ['pattern' => '<' . UrlParam::PARENT_SLUG . '>/<' . UrlParam::CATEGORY_SLUG . '>/<' . UrlParam::SLUG . '>.html', 'route' => 'product/index'],
                ['pattern' => '<' . UrlParam::CATEGORY_SLUG . '>/<' . UrlParam::SLUG . '>.html', 'route' => 'product/index'],
                // Product Category
                ['pattern' => '<' . UrlParam::PARENT_SLUG . '>/<' . UrlParam::SLUG . '>', 'route' => 'product/category'],
                ['pattern' => '<' . UrlParam::PARENT_SLUG . '>/<' . UrlParam::SLUG . '>/', 'route' => 'product/category'],
                ['pattern' => '<' . UrlParam::SLUG . '>', 'route' => 'product/category'],
            ],
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
//            'errorAction' => 'site/error',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => false,
            ],
        ],        
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login',
        ]
    ],  
    // follow config when redirect user to login form if not logged in
    'as beforeRequest' => [  //if guest user access site so, redirect to login page.
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'actions' => ['login'/*, 'error', 'site'*/],
                'allow' => true,
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],    
    'params' => $params,
];
