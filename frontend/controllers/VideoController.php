<?php

namespace frontend\controllers;

use frontend\models\Video;
use frontend\models\Redirect;
use frontend\models\UrlParam;
use yii\helpers\Url;
use Yii;

class VideoController extends BaseController
{
    const ITEMS_PER_PAGE = 16;
    const SESSION_PAGE_KEY = 'Video.page';

    public function actionIndex()
    {
        $slug = Yii::$app->request->get(UrlParam::SLUG);
        if (!($model = Video::findOneBySlug($slug))) {
            Redirect::go();
        }
        $this->link_canonical = $model->getLink();
        if (!Redirect::compareUrl($this->link_canonical)) {
            $this->redirect($this->link_canonical);
        }
//        if ($category = $model->findCategory()) {
//            if ($parent_category = $category->findParent()) {
//                $this->breadcrumbs[] = ['label' => $parent_category->name,
//                    'url' => $parent_category->getLink()];
//            }
//            $this->breadcrumbs[] = ['label' => $category->name,
//                'url' => $category->getLink()];
//        }
        $related_items = $model->getRelatedVideos()->orderBy('published_at DESC')->allPublished();
        $this->breadcrumbs[] = ['label' => 'Video', 'url' => Url::to(['view-all'], true)];
        $this->breadcrumbs[] = ['label' => $model->name, 'url' => $this->link_canonical];

        if (!$this->seo_exist) {
            $this->page_title = $model->page_title;
            $this->h1 = $model->h1;
            $this->meta_title = $model->meta_title;
            $this->meta_description = $model->meta_description;
            $this->meta_keywords = $model->meta_keywords;
            $this->long_description = $model->long_description;
            $this->meta_image = $model->getImage();
        }

        $model->updateCounters(['view_count' => 1]);

        return $this->render('index', [
            'model' => $model,
            'related_items' => $related_items,
            'hot_items' => Video::find()->orderBy('published_at desc')->limit(8)->allPublished()
        ]);
    }

    public function actionViewAll()
    {
        $this->link_canonical = Url::to(['view-all'], true);
        $this->breadcrumbs[] = ['label' => 'Video', 'url' => $this->link_canonical];

//        $page = Yii::$app->request->get('page', 0);
//        if (!is_numeric($page) || $page == 1 || $page < 0) {
//            $this->redirect($this->link_canonical, 301);
//        }
//        if ($page > 1) {
//            $this->meta_index = 'noindex';
//            $this->meta_follow = 'nofollow';
//            $this->page_title .= " - trang $page";
//            $this->meta_keywords .= " - trang $page";
//            $this->meta_description .= " - trang $page";
//        } else {
//            $page = 1;
//        }
        $page = 1;

        $models = Video::find()
            ->limit(static::ITEMS_PER_PAGE + 1)
            ->offset(($page - 1) * static::ITEMS_PER_PAGE)
            ->orderBy('published_at desc')
            ->allPublished();

        Yii::$app->session->set(self::SESSION_PAGE_KEY, $page + 1);

//        if ($page > 1 && !isset($models[0])) {
//            $this->redirect($this->link_canonical, 301);
//        }

//        $totalItems = Video::find()
//                ->countPublished();
//
//        $total = ceil($totalItems / static::ITEMS_PER_PAGE);
//        $firstItemOnPage = $totalItems > 0
//                ? ($page-1) * static::ITEMS_PER_PAGE + 1 : 0;
//        $lastItemOnPage = $totalItems < $page * static::ITEMS_PER_PAGE
//                ? $totalItems : $page * static::ITEMS_PER_PAGE;
//        $pagination = [
//            'firstItemOnPage' => $firstItemOnPage,
//            'lastItemOnPage' => $lastItemOnPage,
//            'totalItems' => $totalItems,
//            'current' => $page,
//            'total' => $total,
//        ];

        return $this->render('viewAll', [
            'title' => 'Video',
            'models' => array_slice($models, 0, self::ITEMS_PER_PAGE),
            'has_more' => isset($models[static::ITEMS_PER_PAGE])
        ]);
    }

    public function actionAjaxGetItems()
    {
        $this->layout = false;

        $query = Video::find();

        $page = Yii::$app->session->get(self::SESSION_PAGE_KEY, 2);
        Yii::$app->session->set(self::SESSION_PAGE_KEY, $page + 1);
        $models = $query
            ->limit(static::ITEMS_PER_PAGE + 1)
            ->offset(($page - 1) * static::ITEMS_PER_PAGE)
            ->orderBy('published_at desc')
            ->allPublished();
        return json_encode([
            'content' => $this->render('items', ['models' =>array_slice($models, 0, self::ITEMS_PER_PAGE)]),
            'has_more' => isset($models[static::ITEMS_PER_PAGE])
        ]);
    }

    public function actionCounter()
    {
        $model = Video::findOne(Yii::$app->request->post('id'));
        if ($model) {
            $comment_count = Yii::$app->request->post('comment_count');
            $like_count = Yii::$app->request->post('like_count');
            $share_count = Yii::$app->request->post('share_count');
            $check = false;
            if (!empty($comment_count)) {
                $model->comment_count = $comment_count;
                $check = true;
            }
            if (!empty($like_count)) {
                $model->like_count = $like_count;
                $check = true;
            }
            if (!empty($share_count)) {
                $model->share_count = $share_count;
                $check = true;
            }
            if ($check) {
                $model->save();
            }
        }
        return;
    }
}
