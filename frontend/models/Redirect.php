<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class Redirect extends ActiveRecord
{
    
    public static function compareUrl($url1, $url2 = null)
    {
        !empty($url2) or $url2 = Yii::$app->request->absoluteUrl;
        
        !is_numeric($question_mark_pos1 = strpos($url1, '?'))
        or $url1 = substr($url1, 0, $question_mark_pos1 - strlen($url1));
        
        !is_numeric($question_mark_pos2 = strpos($url2, '?'))
        or $url2 = substr($url2, 0, $question_mark_pos2 - strlen($url2));
        
        return $url1 === $url2;
    }
    
    public static function go()
    {
        if (($url = static::getRedirectUrl()) === false) {
            $url = static::getRedirectUrlBySlug();
        }
        if ($url !== false ) {
            return Yii::$app->response->redirect($url, 301);
        } else {
            throw new NotFoundHttpException('Page not found.');
        }        
    }
    
    public static function sitemap()
    {
        if (($url = static::getRedirectUrl()) === false) {
            $url = static::getRedirectSitemapBySlug();
        }
        if ($url !== false ) {
            return Yii::$app->response->redirect($url, 301);
        } else {
            throw new NotFoundHttpException('Page not found.');
        }        
    }
    
    public static function getRedirectUrl($from_url = null)
    {
        $result = '';
        !empty($from_url) or $from_url = Yii::$app->request->absoluteUrl;
        $from_url_json = json_encode($from_url);
        if ($model = RedirectUrl::find()->where(['like', 'from_urls', $from_url_json])->andWhere(['is_active' => 1])->one()) {
            $result = $model->to_url;
        } else {
            $result = false;
        }
        return $result;
    }
    
    public static function getRedirectUrlBySlug($slug = null)
    {
        $result = '';
        !empty($slug) or $slug = Yii::$app->request->get('slug');
        $slug_json = json_encode($slug);
//        $urlManager = 'urlManager_'.strtotime('2016-02-26 10:00:00');
//        var_dump(Yii::$app->$urlManager->createUrl(['article/index']));
        if ($model = Article::find()->where(['like', 'old_slugs', $slug_json])->one()) {
            $result = $model->getLink();
        } else if ($model = ArticleCategory::find()->where(['like', 'old_slugs', $slug_json])->one()) {
            $result = $model->getLink();
        } else {
            $result = false;
        }
        return $result;
    }
    
    public static function getRedirectSitemapBySlug($slug = null)
    {
        $result = '';
        !empty($slug) or $slug = Yii::$app->request->get('slug');
        $slug_json = json_encode($slug);
//        $urlManager = 'urlManager_'.strtotime('2016-02-26 10:00:00');
//        var_dump(Yii::$app->$urlManager->createUrl(['article/index']));
        if ($model = ArticleCategory::find()->where(['like', 'old_slugs', $slug_json])->one()) {
            $result = \yii\helpers\Url::to(['sitemap/article-category', 'slug' => $model->slug], true);
        } else {
            $result = false;
        }
        return $result;
    }
}