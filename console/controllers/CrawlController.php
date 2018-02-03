<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 2/6/2017
 * Time: 9:21 AM
 */

namespace console\controllers;

use backend\models\ArticleCategory;
use common\utils\Common;
use common\utils\phpthumb\PhpThumb;
use common\utils\phpthumb\PhpThumbFactory;
use Yii;
use backend\models\Article;
use console\models\CrawledUrl;
use yii\console\Controller;
use yii\helpers\VarDumper;
use common\utils\FileUtils;

class CrawlController extends Controller
{
    public $offset;
    public $limit;
    public $min_id;

    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['offset', 'limit', 'min_id']);
    }

    const SITEMAP_URL = 'http://thethao.vnexpress.net/sitemap.xml';
    public function curl_get_contents($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function actionGetLinks()
    {
        echo "ok\n";
        $sitemap_content = self::curl_get_contents(self::SITEMAP_URL);
        $regex = "/<loc>((?:(?!<loc>)[\s\S])*)<\/loc>/";
        preg_match_all($regex, $sitemap_content, $sitemap_locs);
        if (!empty($sitemap_locs[1])) {
            foreach ($sitemap_locs[1] as $sitemap_child_url) {
                echo "$sitemap_child_url\n";
                $sitemap_child_content = self::curl_get_contents(str_replace('&amp;', '&', $sitemap_child_url));
                echo "$sitemap_child_content\n";
                $regex = "/<url>((?:(?!<url>)[\s\S])*)<\/url>/";
                preg_match_all($regex, $sitemap_child_content, $url_details);
                if (!empty($url_details[1])) {
                    foreach ($url_details[1] as $url_detail) {
                        echo "$url_detail\n";
                        $regex = "/<loc>((?:(?!<loc>)[\s\S])*)<\/loc>/";
                        preg_match_all($regex, $url_detail, $arr_url);
                        $regex = "/<image:loc>((?:(?!<image:loc>)[\s\S])*)<\/image:loc>/";
                        preg_match_all($regex, $url_detail, $arr_image);
//                        $regex = "/<news:title>\s+<!\[CDATA\[((?:(?!<news:title>)[\s\S])*)\]\]>\s+<\/news:title>/";
                        $regex = "/<news:title>((?:(?!<news:title>)[\s\S])*)<\/news:title>/";
                        preg_match_all($regex, $url_detail, $arr_title);
                        $regex = "/<news:publication_date>((?:(?!<news:publication_date>)[\s\S])*)<\/news:publication_date>/";
                        preg_match_all($regex, $url_detail, $arr_time);
                        $regex = "/<news:keywords>((?:(?!<news:keywords>)[\s\S])*)<\/news:keywords>/";
//                        $regex = "/<news:keywords>\s+<!\[CDATA\[((?:(?!<news:keywords>)[\s\S])*)\]\]>\s+<\/news:keywords>/";
                        preg_match_all($regex, $url_detail, $arr_keywords);

                        $crawled_url = new CrawledUrl();
                        if (isset($arr_url[1][0])) {
                            $crawled_url->url = $arr_url[1][0];
                            if (isset($arr_title[1][0])) {
                                $crawled_url->title = trim(str_replace('<![CDATA[', '', str_replace(']]>', '', $arr_title[1][0])));
                            }
                            if (isset($arr_image[1][0])) {
                                $crawled_url->img_src = $arr_image[1][0];
                            }
                            if (isset($arr_keywords[1][0])) {
                                $crawled_url->keywords = trim(str_replace('<![CDATA[', '', str_replace(']]>', '', $arr_keywords[1][0])));
                            }
                            if (isset($arr_time[1][0])) {
                                $crawled_url->time = strtotime($arr_time[1][0]);
                            }
                            $crawled_url->host = 'vnexpress.net';
                            $crawled_url->created_at = time();
                            if ($crawled_url->save()) {
                                echo $crawled_url->url . '\n';
                            } else {
                                echo VarDumper::dumpAsString($crawled_url->errors) . '\n';
                            }
                        }
                    }
                }
            }
        }
    }

    public function actionGetContents()
    {
        define('MAX_FILE_SIZE', 6000000);

        echo $this->offset . '; ' . $this->limit . "\n";

        foreach (CrawledUrl::find()->where(['content' => null])
                     ->andWhere(['>=', 'id', $this->min_id])
                     ->offset($this->offset)->limit($this->limit)
                     ->each(10) as $item
        ) {
            try {

                $source = self::curl_get_contents($item->url);
                $regex = "/<h3 class=\"short_intro txt_666\">((?:(?!<\/h3>)[\s\S])*)<\/h3>/";
                preg_match_all($regex, $source, $arr_description);

                if (isset($arr_description[1][0])) {
                    $item->description = $arr_description[1][0];
                }

                $source = self::curl_get_contents($item->url);
                if (strpos($source, '<div class="fck_detail width_common block_ads_connect">') !== false) {
                    $regex = "/<div class=\"fck_detail width_common block_ads_connect\">\s+((?:(?!<\/div>)[\s\S])*)\s+<\/div>/";
                } else if (strpos($source, '<div id="article_content" class="block_ads_connect">') !== false) {
                    $regex = "/<div id=\"article_content\" class=\"block_ads_connect\">\s+((?:(?!<\/div>\s+<script)[\s\S])*)\s+<\/div>/";
                }
                preg_match_all($regex, $source, $arr_content);

                if (isset($arr_content[1][0])) {
                    $item->content = $arr_content[1][0];
                }

                if ($item->save()) {
                    echo $item->id . ': ' . $item->description . "\n";
                }
            } catch (\Exception $exception) {
                echo $exception->getTraceAsString();
                continue;
            }
        }
    }

    public function actionCategory()
    {
        $categories = [];
        foreach (CrawledUrl::find()->all() as $item) {
            $category = basename(dirname($item->url));
            $parent = basename(dirname(dirname($item->url)));

            if (strpos($parent, '.') === false) {
                $parent_model = new ArticleCategory();
                $parent_model->slug = $parent_model->name = $parent_model->h1 = $parent_model->meta_title
                    = $parent_model->page_title = $parent_model->meta_description = $parent_model->meta_keywords
                    = $parent;
                $parent_model->is_active = 1;
                $parent_model->created_at = strtotime('2000-01-01');
                $parent_model->created_by = 'admin';
                if ($parent_model->save()) {
                    echo $parent_model->id . "\n";
                } else {
                    echo VarDumper::dumpAsString($parent_model->errors);
                }
            }

            $model = new ArticleCategory();
            $model->slug = $model->name = $model->h1 = $model->meta_title
                = $model->page_title = $model->meta_description = $model->meta_keywords
                = $category;
            $model->is_active = 1;
            if ($pmodel = ArticleCategory::find()->where(['slug' => $parent])->one()) {
                $model->parent_id = $pmodel->id;
            }
            $model->created_at = strtotime('2000-01-01');
            $model->created_by = 'admin';
            if ($model->save()) {
                echo $model->id . "\n";
            } else {
                echo VarDumper::dumpAsString($model->errors);
            }
//            if (!isset($categories[$parent])) {
                $categories[$parent][$category] = $category;
//            }
        }
        print_r($categories);
    }

    public function actionArticle()
    {
        foreach (CrawledUrl::find()->where(['is not', 'content', null])->all() as $item) {
            $model = new Article();

            $model->name = $model->page_title = $model->meta_title = $model->h1 = $item->title;
            $model->meta_keywords = $item->keywords;
            $path_info = pathinfo($item->url);
            $model->slug = preg_replace("/-\d+.html/", ".html", $path_info['filename']);;
            $model->is_active = 1;

            if ($category = ArticleCategory::find()->where(['slug' => basename(dirname($item->url))])->one()) {
                $model->category_id = $category->id;
            }

            $model->created_at = $item->time;
            $model->published_at = $item->time;
            $model->created_by = 'admin';
            $model->image_path = FileUtils::generatePath($model->created_at, Yii::$app->params['images_folder']);
            $model->image = basename($item->img_src);
            $model->description = $model->meta_description = $item->description;
            $model->content = $item->content;

            $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0777, true);
            }
            $targetUrl = Yii::$app->params['images_url'] . $model->image_path;

            $copyResult = FileUtils::copyImage([
                'imageName' => $model->image,
                'fromFolder' => dirname($item->img_src),
                'toFolder' => $targetFolder,
                'resize' => array_values(Article::$image_resizes),
//                'resize' => [],
                'removeInputImage' => false,
            ]);
            if ($copyResult['success']) {
                $model->image = $copyResult['imageName'];
            }

//            $model->content = FileUtils::copyContentImages([
//                'content' => $model->content,
////                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
//                'toFolder' => $targetFolder,
//                'toUrl' => $targetUrl,
//                'removeInputImage' => false,
//            ]);

            $regex = "/src=\"((?:(?!\")[\s\S])*)\"/";
            preg_match_all($regex, $model->content, $arr_images);

            if (isset($arr_images[1])) {
                $i = 0;
                foreach ($arr_images[1] as $img_src) {
                    if (strpos($img_src, $targetUrl) !== false) {
                        continue;
                    }
                    $img_data = self::curl_get_contents($img_src);
                    $path_info = pathinfo($img_src);
                    do {
                        $i++;
                        $filename = Common::vn_str_filter($model->name) . '-' . $i . '.' . $path_info['extension'];
                        foreach (FileUtils::$file_name_replace as $search => $replace) {
                            $filename = str_replace($search, $replace, $filename);
                        }
                    } while (file_exists($targetFolder . $filename));
                    file_put_contents($targetFolder . $filename, $img_data);
                    $model->content = str_replace($img_src, $targetUrl . $filename, $model->content);
                }
            }

            if ($model->save()) {
                echo "{$model->id}\n";
            } else {
                echo VarDumper::dumpAsString($model->errors) . "\n";
            }
        }
    }

    public function actionCheckOutboundLinks()
    {
        foreach (Article::find()->all() as &$item) {
            $regex = "/(http|https):\/\/+[^\"\s]+/";
            preg_match_all($regex, $item->content, $arr_links);
            if (isset($arr_links[0])) {
                foreach ($arr_links[0] as $link) {
                    if (strpos($link, 'thethaohangngay.com.vn') === false) {
                        $item->content = str_replace($link, '', $item->content);
                        echo $link . "\n";
                        if ($item->save()) {
                            echo $item->id . "\n";
                        } else {
                            echo VarDumper::dumpAsString($item->errors) . "\n";
                        }
                    }
                }
            }
        }
    }

    public function actionHideCategory()
    {
        foreach (ArticleCategory::find()->all() as $category) {
            if (strpos($category->name, ' ') === false && strpos($category->name, '-') !== false) {
                $category->is_active = 0;
                if ($category->save()) {
                    echo $category->name . "\n";
                }
            }
        }
    }

    public function actionVnexpress()
    {
        $sitemap_child_url = 'http://vnexpress.net/sitemap/1002565/sitemap-news.xml?y='.date('Y').'&m='.date('m').'&d='.date('d');
        $sitemap_child_content = self::curl_get_contents(str_replace('&amp;', '&', $sitemap_child_url));
        $regex = "/<url>((?:(?!<url>)[\s\S])*)<\/url>/";
        preg_match_all($regex, $sitemap_child_content, $url_details);
        if (!empty($url_details[1])) {
            foreach ($url_details[1] as $url_detail) {
//                echo "$url_detail\n";
                $regex = "/<loc>((?:(?!<loc>)[\s\S])*)<\/loc>/";
                preg_match_all($regex, $url_detail, $arr_url);
                $regex = "/<image:loc>((?:(?!<image:loc>)[\s\S])*)<\/image:loc>/";
                preg_match_all($regex, $url_detail, $arr_image);
//                        $regex = "/<news:title>\s+<!\[CDATA\[((?:(?!<news:title>)[\s\S])*)\]\]>\s+<\/news:title>/";
                $regex = "/<news:title>((?:(?!<news:title>)[\s\S])*)<\/news:title>/";
                preg_match_all($regex, $url_detail, $arr_title);
                $regex = "/<news:publication_date>((?:(?!<news:publication_date>)[\s\S])*)<\/news:publication_date>/";
                preg_match_all($regex, $url_detail, $arr_time);
                $regex = "/<news:keywords>((?:(?!<news:keywords>)[\s\S])*)<\/news:keywords>/";
//                        $regex = "/<news:keywords>\s+<!\[CDATA\[((?:(?!<news:keywords>)[\s\S])*)\]\]>\s+<\/news:keywords>/";
                preg_match_all($regex, $url_detail, $arr_keywords);

                $crawled_url = new CrawledUrl();
                if (isset($arr_url[1][0])) {
                    $crawled_url->url = $arr_url[1][0];
                    if (isset($arr_title[1][0])) {
                        $crawled_url->title = trim(str_replace('<![CDATA[', '', str_replace(']]>', '', $arr_title[1][0])));
                    }
                    if (isset($arr_image[1][0])) {
                        $crawled_url->img_src = $arr_image[1][0];
                    }
                    if (isset($arr_keywords[1][0])) {
                        $crawled_url->keywords = trim(str_replace('<![CDATA[', '', str_replace(']]>', '', $arr_keywords[1][0])));
                    }
                    if (isset($arr_time[1][0])) {
                        $crawled_url->time = strtotime($arr_time[1][0]);
                    }

                    $source = self::curl_get_contents($crawled_url->url);
                    $regex = "/<h3 class=\"short_intro txt_666\">((?:(?!<\/h3>)[\s\S])*)<\/h3>/";
                    preg_match_all($regex, $source, $arr_description);

                    if (isset($arr_description[1][0])) {
                        $crawled_url->description = $arr_description[1][0];
                    }

                    $source = self::curl_get_contents($crawled_url->url);
                    if (strpos($source, '<div class="fck_detail width_common block_ads_connect">') !== false) {
                        $regex = "/<div class=\"fck_detail width_common block_ads_connect\">\s+((?:(?!<\/div>\s+<script)[\s\S])*)\s+<\/div>\s+<script/";
                    } else if (strpos($source, '<div id="article_content" class="block_ads_connect">') !== false) {
                        $regex = "/<div id=\"article_content\" class=\"block_ads_connect\">\s+((?:(?!<\/div>\s+<script)[\s\S])*)\s+<\/div>\s+<script/";
                    }
                    preg_match_all($regex, $source, $arr_content);

                    if (isset($arr_content[1][0])) {
                        $crawled_url->content = $arr_content[1][0];
                    }

                    $crawled_url->host = 'vnexpress.net';
                    $crawled_url->created_at = time();

                    if ($crawled_url->save()) {
                        echo $crawled_url->url . '\n';
                    } else {
                        echo VarDumper::dumpAsString($crawled_url->errors) . '\n';
                    }

                    // Create article
                    $model = new Article();

                    $model->name = $model->page_title = $model->meta_title = $model->h1 = $crawled_url->title;
                    $model->meta_keywords = $crawled_url->keywords;
                    $path_info = pathinfo($crawled_url->url);
                    $model->slug = preg_replace("/-\d+.html/", ".html", $path_info['filename']);;
                    $model->is_active = 0;

                    if ($category = ArticleCategory::find()->where(['slug' => basename(dirname($crawled_url->url))])->one()) {
                        $model->category_id = $category->id;
                    } else {
                        $model->category_id = 186;
                    }

                    $model->created_at = $crawled_url->time;
                    $model->published_at = $crawled_url->time;
                    $model->created_by = 'vnexpress';
                    $model->image_path = FileUtils::generatePath($model->created_at, Yii::$app->params['images_folder']);
                    $model->image = basename($crawled_url->img_src);
                    $model->description = $model->meta_description = $crawled_url->description;
                    $model->content = $crawled_url->content;

                    $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
                    if (!file_exists($targetFolder)) {
                        mkdir($targetFolder, 0777, true);
                    }
                    $targetUrl = Yii::$app->params['images_url'] . $model->image_path;

                    try {
                        $copyResult = FileUtils::copyImage([
                            'imageName' => $model->image,
                            'fromFolder' => dirname($crawled_url->img_src),
                            'toFolder' => $targetFolder,
                            'resize' => array_values(Article::$image_resizes),
                            'removeInputImage' => false,
                        ]);
                        if ($copyResult['success']) {
                            $model->image = $copyResult['imageName'];
                        }
                    } catch (\Exception $e) {
                        echo $e->getTraceAsString();
                        continue;
                    }

                    $regex = "/src=\"((?:(?!\")[\s\S])*)\"/";
                    preg_match_all($regex, $model->content, $arr_images);

                    if (isset($arr_images[1])) {
                        $i = 0;
                        foreach ($arr_images[1] as $img_src) {
                            if (strpos($img_src, $targetUrl) !== false) {
                                continue;
                            }
                            $img_data = self::curl_get_contents($img_src);
                            $path_info = pathinfo($img_src);
                            do {
                                $i++;
                                $filename = Common::vn_str_filter($model->name) . '-' . $i . '.' . $path_info['extension'];
                                foreach (FileUtils::$file_name_replace as $search => $replace) {
                                    $filename = str_replace($search, $replace, $filename);
                                }
                            } while (file_exists($targetFolder . $filename));
                            file_put_contents($targetFolder . $filename, $img_data);
                            $model->content = str_replace($img_src, $targetUrl . $filename, $model->content);
                        }
                    }

                    if ($model->save()) {
                        echo "{$model->id}\n";
                    } else {
                        echo VarDumper::dumpAsString($model->errors) . "\n";
                    }
                }
            }
        }
    }

    public function actionVietnamnet()
    {
        $sitemap_content = self::curl_get_contents('http://vietnamnet.vn/sitemap.xml');
        $regex = "/<loc>((?:(?!<\/loc>)[\s\S])*)<\/loc>/";
        preg_match_all($regex, $sitemap_content, $arr_urls);
//        var_dump($arr_urls);
        if (isset($arr_urls[1])) {
            foreach ($arr_urls[1] as $url) {
                if (strpos($url, '/the-thao/')) {
                    echo $url . "\n";
                    $source = self::curl_get_contents($url);

                    $regex = "/<title>((?:(?!<\/title>)[\s\S])*)<\/title>/";
                    preg_match_all($regex, $source, $arr_title);

                    $regex = "/<meta name=\"description\" content=\"((?:(?!\/>)[\s\S])*)\" \/>/";
                    preg_match_all($regex, $source, $arr_description);

                    $regex = "/<meta name=\"keywords\" content=\"((?:(?!\/>)[\s\S])*)\" \/>/";
                    preg_match_all($regex, $source, $arr_keywords);

                    $regex = "/<meta property=\"og:image\" content=\"((?:(?!\/>)[\s\S])*)\" \/>/";
                    preg_match_all($regex, $source, $arr_image);

                    $regex = "/<span class=\"ArticleDate\">((?:(?!<\/span>)[\s\S])*)<\/span>/";
                    preg_match_all($regex, $source, $arr_time);

                    $regex = "/<div id=\"ArticleContent\" class=\"ArticleContent\">(.*)<\/div><div class=\"m-t-10 bo-bt m-b-10 clearfix\">/";
                    preg_match_all($regex, $source, $arr_content);


                    $crawled_url = new CrawledUrl();
                    $crawled_url->url = $url;
                    $crawled_url->title = isset($arr_title[1][0]) ? $arr_title[1][0] : '';
                    $crawled_url->description = isset($arr_description[1][0]) ? $arr_description[1][0] : '';
                    $crawled_url->keywords = isset($arr_keywords[1][0]) ? $arr_keywords[1][0] : $crawled_url->title;
                    $crawled_url->img_src = isset($arr_image[1][0]) ? $arr_image[1][0] : '';
                    $crawled_url->content = isset($arr_content[1][0]) ? $arr_content[1][0] : '';
                    if (isset($arr_time[1][0])) {
                        $crawled_url->time = strtotime(preg_replace("/(([^\/\:\-\d]))/", ' ', str_replace('/', '-', str_replace('GMT+7', '', $arr_time[1][0]))));
                    }
//                    echo $crawled_url->time . "\n";
                    $crawled_url->created_at = time();
                    $crawled_url->host = 'vietnamnet.vn';

                    if ($crawled_url->save()) {
//                        echo $crawled_url->id . "\n";

                        // Create article
                        $model = new Article();

                        $model->name = $model->page_title = $model->meta_title = $model->h1 = $crawled_url->title;
                        $model->meta_keywords = $crawled_url->keywords;
                        $path_info = pathinfo($crawled_url->url);
                        $model->slug = preg_replace("/-\d+.html/", "", $path_info['filename']);
//                        echo 'SLUG: ' . $model->slug . "\n\n\n";
                        $model->is_active = 0;

                        if ($category = ArticleCategory::find()->where(['slug' => basename(dirname($crawled_url->url))])->one()) {
                            $model->category_id = $category->id;
                        } else {
                            $model->category_id = 186;
                        }

                        $model->created_at = $crawled_url->time;
                        $model->published_at = $crawled_url->time;
                        $model->created_by = 'vietnamnet';
                        $model->image_path = FileUtils::generatePath($model->created_at, Yii::$app->params['images_folder']);
                        $model->image = basename($crawled_url->img_src);
                        $model->description = $model->meta_description = $crawled_url->description;
                        $model->content = $crawled_url->content;

                        $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
                        if (!file_exists($targetFolder)) {
                            mkdir($targetFolder, 0777, true);
                        }
                        $targetUrl = Yii::$app->params['images_url'] . $model->image_path;

//                        try {
//                            $copyResult = FileUtils::copyImage([
//                                'imageName' => $model->image,
//                                'fromFolder' => dirname($crawled_url->img_src),
//                                'toFolder' => $targetFolder,
//                                'resize' => array_values(Article::$image_resizes),
//                                'removeInputImage' => false,
//                            ]);
//                            if ($copyResult['success']) {
//                                $model->image = $copyResult['imageName'];
//                            }
//                        } catch (\Exception $e) {
//                            echo $e->getTraceAsString();
//                            continue;
//                        }

                        $i = 0;
                        $img_data = self::curl_get_contents($crawled_url->img_src);
                        $path_info = pathinfo($crawled_url->img_src);
                        if (isset($path_info['extension'])) {
                            do {
                                $i++;
                                $filename = preg_replace("/(([^\w]))/", " ", Common::vn_str_filter($model->name))
                                    . ($i > 1 ? ('-' . $i) : '') . '.' . $path_info['extension'];
                                $filename = str_replace(' ', '-', $filename);
                                while (strpos($filename, '--') !== false) {
                                    $filename = str_replace('--', '-', $filename);
                                }
                            } while (file_exists($targetFolder . $filename));
                            file_put_contents($targetFolder . $filename, $img_data);

                            foreach (array_values(Article::$image_resizes) as $dim) {
                                $dim = FileUtils::stringToArray($dim);
                                $thumb = PhpThumbFactory::create($targetFolder . $filename);
                                if ($thumb->resize($dim[0], $dim[1])) {
                                    $thumb->save($targetFolder . basename($filename) . FileUtils::getResizeSuffix($dim, FileUtils::SUFFIX_TEMPLATE . '.' . $path_info['extension']));
                                }
                            }
                            $model->image = $filename;
                        }

                        $regex = "/src=\"((?:(?!\")[\s\S])*)\"/";
                        preg_match_all($regex, $model->content, $arr_images);

                        if (isset($arr_images[1])) {
                            foreach ($arr_images[1] as $img_src) {
                                if (strpos($img_src, $targetUrl) !== false) {
                                    continue;
                                }
                                if (($pos = strpos($img_src, '?')) !== false) {
                                    $img_src = substr($img_src, $pos);
                                }
                                $img_data = self::curl_get_contents($img_src);
                                $path_info = pathinfo($img_src);
                                if (isset($path_info['extension'])) {
                                    do {
                                        $i++;
                                        $filename = preg_replace("/(([^\w]))/", " ", Common::vn_str_filter($model->name))
                                            . '-' . $i . '.' . $path_info['extension'];
                                        $filename = str_replace(' ', '-', $filename);
                                        while (strpos($filename, '--') !== false) {
                                            $filename = str_replace('--', '-', $filename);
                                        }
                                    } while (file_exists($targetFolder . $filename));
                                    try {
                                        file_put_contents($targetFolder . $filename, $img_data);
                                    } catch (\Exception $e) {
                                        echo $e->getTraceAsString();
                                        continue;
                                    }
                                    $model->content = str_replace($img_src, $targetUrl . $filename, $model->content);
                                }
                            }
                        }

                        $regex = "/(http|https):\/\/+[^\"\s]+/";
                        preg_match_all($regex, $model->content, $arr_links);
                        if (isset($arr_links[0])) {
                            foreach ($arr_links[0] as $link) {
                                if (strpos($link, 'thethaohangngay.com.vn') === false) {
                                    $model->content = str_replace($link, '', $model->content);
                                }
                            }
                        }

                        $regex = "/href=\"+[^\"\s]+\"/";
                        preg_match_all($regex, $model->content, $arr_links);
                        if (isset($arr_links[0])) {
                            foreach ($arr_links[0] as $link) {
                                if (strpos($link, 'thethaohangngay.com.vn') === false) {
                                    $model->content = str_replace($link, 'href=""', $model->content);
                                }
                            }
                        }



                        if ($model->save()) {
                            echo "{$model->id}\n";
                        } else {
                            echo VarDumper::dumpAsString($model->errors) . "\n";
                        }
                    }

                }
            }
        }
    }
}