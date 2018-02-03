<?php

namespace frontend\controllers;

use frontend\models\ArticleCategory;
use frontend\models\ProductCategory;
use frontend\models\UrlParam;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SitemapController extends BaseController
{
    public $layout;
    
    const ALIAS_ARTICLE = 'bai-viet';
    const ALIAS_PRODUCT = 'san-pham';
    
    public function actionViewAll()
    {
        $items = [];
        
        foreach (ArticleCategory::indexData() as $category) {
            $items[] = Url::to(['sitemap/index', UrlParam::ALIAS => self::ALIAS_ARTICLE, UrlParam::SLUG => $category->slug], true);
        }
        
        foreach (ProductCategory::indexData() as $category) {
            $items[] = Url::to(['sitemap/index', UrlParam::ALIAS => self::ALIAS_PRODUCT, UrlParam::SLUG => $category->slug], true);
        }
        
        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        $this->layout = false;
        
        return $this->render('view-all', [
            'items' => $items
        ]);
    }
    
    public function actionIndex()
    {
        $alias = Yii::$app->request->get(UrlParam::ALIAS, '');
        $slug = Yii::$app->request->get(UrlParam::SLUG, '');
        
        $attr_to_get_imgs = '';
        
        switch ($alias) {
            case self::ALIAS_ARTICLE:
                if (!$model_category = ArticleCategory::findOneBySlug($slug)) {
                    throw new NotFoundHttpException;
                }
                $models = $model_category->getArticles()->allPublished();
                $attr_to_get_imgs = 'long_description';
                break;
            case self::ALIAS_PRODUCT:
                if (!$model_category = ProductCategory::findOneBySlug($slug)) {
                    throw new NotFoundHttpException;
                }
                $models = $model_category->getProducts()->allPublished();
                $attr_to_get_imgs = 'content';
                break;
                
        }
        
        $items = [];
        foreach ($models as $item) {
            $imgs = [$item->getImage()];
            $matches = array();
            
            preg_match_all('/src="(.*?)"/i', $item->{$attr_to_get_imgs}, $matches);
            foreach($matches[0] as $img_src) {
                if (strpos($img_src, Yii::$app->request->hostInfo) !== false) { 
                    $imgs[] = substr(substr($img_src, 0, -1), 5);
                }
            }
            $items[] = ['url' => $item->getLink(), 'imgs' => $imgs];
        }
        
        $home = ['url' => Url::home(true), 'img' => ''];

        $category = ['url' => $model_category->getLink(), 'img' => $model_category->getImage()];

        $parent = null;

        $children = [];

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        $this->layout = false;

        return $this->render('index', [
            'home' => $home,
            'parent' => $parent,
            'category' => $category,
            'children' => $children,
            'items' => $items,
        ]);
    }
    
}
