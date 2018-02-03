<?php
namespace frontend\controllers;

use common\utils\MobileDetect;
use frontend\models\Article;
use frontend\models\ArticleCategory;
use frontend\models\Info;
use frontend\models\Menu;
use frontend\models\ProductCategory;
use frontend\models\SeoInfo;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Base Controller
 */
class BaseController extends Controller {
    public
    $link_canonical,
    $page_title,
    $meta_title,
    $meta_keywords,
    $meta_description,
    $long_description,
    $h1,
    $meta_index,
    $meta_follow,
    $meta_image,
    $breadcrumbs = array(),
    $seo_exist = false,
    $is_ios,
    $is_android,
    $is_windowsphone,
    $is_tablet,
    $is_mobile,
    $scr,
    $sm_scr,
    $md_scr,
    $lg_scr,
    $seo_info;
    public function init()
    {
        parent::init();

        $this->meta_index = 'index';
        $this->meta_follow = 'follow';
        $this->meta_image = Yii::$app->params['default_image'];
        $this->breadcrumbs[] = ['label' => 'Trang chủ', 'url' => Url::home(true)];
        
        $mobile_detect = new MobileDetect;
        $this->is_mobile = $mobile_detect->isMobile();
        $this->is_tablet = $mobile_detect->isTablet();
        $this->scr = $this->is_tablet ? 'md' : ($this->is_mobile ? 'sm' : 'lg');
        $this->sm_scr = $this->scr == 'sm';
        $this->md_scr = $this->scr == 'md';
        $this->lg_scr = $this->scr == 'lg';
    }
    public function beforeAction($action) {
        parent::beforeAction($action);
        return true;
        
    }
    public function beforeAction1($action) {
        parent::beforeAction($action);

        if (in_array(Yii::$app->requestedRoute, [
            'site/index',
            'product/view-all',
            'article/view-all',
            'contact/index',
        ])) {
            if ($seoInfo = SeoInfo::getCurrent()) {
                $this->seo_exist = true;
                $this->page_title = $seoInfo->page_title;
                $this->h1 = $seoInfo->h1;
                $this->meta_title = $seoInfo->meta_title;
                $this->meta_description = $seoInfo->meta_description;
                $this->meta_keywords = $seoInfo->meta_keywords;
                $this->long_description = $seoInfo->long_description;
                $this->meta_image = $seoInfo->getImage();
            }
        }

        // Menu data
        // Data 1

        $data1['home'] = [
            'label' => 'Trang chủ',
            'url' => Url::home(true),
            'parent_key' => null
        ];
        
        
        $data1['aboutus'] = [
            'label' => 'Giới thiệu',
            'url' => Url::to(['site/about']),
            'parent_key' => null
        ];
        
        $data1['services'] = [
            'label' => 'Dịch vụ',
            'url' => Url::to(['site/service']),
            'parent_key' => null
        ];
        
//        $data1['products'] = [
//            'label' => 'Sản phẩm',
//            'url' => Url::home(true),
//            'parent_key' => null
//        ];
        
//        $data1['news'] = [
//            'label' => 'Tin tức',
//            'url' => ,
//            'parent_key' => null
//        ];
        
        
        
        
//        $data2 = [];
//
        $article_cats = ArticleCategory::indexData();
        foreach ($article_cats as $item) {
            $data1[$item->id] = [
                'label' => $item->name,
                'url' => $item->getLink(),
                'parent_key' => 'news'
            ];
        }
        $data1['contact'] = [
            'label' => 'Liên hệ',
            'url' => Url::to(['contact/index']),
            'parent_key' => null
        ];

//        $data2['video'] = [
//            'label' => 'Video',
//            'url' => Url::to(['video/view-all'], true),
//            'parent_key' => null
//        ];
        
        $options = [
            'cache' => [
                'duration' => Yii::$app->params['cache_duration'],
                'enable' => Yii::$app->params['enable_cache']
            ]
        ];
        
        Menu::init(['one' => $data1], $options);
        
//        echo '<!--';
//        var_dump(Yii::$app->requestedRoute);
//        var_dump(Yii::$app->request->queryParams);
//        echo '-->';
        
        return true;
    }
}