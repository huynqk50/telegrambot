<?php
namespace backend\controllers;

use backend\models\ArticleCategory;
use backend\models\User;
use common\utils\FileUtils;
use backend\models\Article;
use backend\models\Product;
use Yii;
use yii\db\Connection;
use yii\web\Controller;

class MigrateController extends Controller
{
    const IMG_HOST = 'http://images.honglamhuong.com/';
    
    private static function connect()
    {
        return new Connection([
            'dsn' => 'mysql:host=104.199.132.157;dbname=honglamhuong',
            'username' => 'mig_hlh_com',
            'password' => '$%$%GG_@333AS',
            'charset' => 'utf8',
        ]);
    }
    
    private static function getOldImagePath($id, $date) {
        
        is_int($date) or $date = strtotime($date);
        
        return date("/Ym/$id/", $date);
    }
    
    public function actionArticleCategory($parent = 'yes')
    {
        $conn = self::connect();
        $conn->open();
        
        if ($parent == 'yes') {
            $data = $conn->createCommand('SELECT * FROM honglamhuong.vt_news_category where parent_id is null')->queryAll();
        } else if ($parent == 'no') {
            $data = $conn->createCommand('SELECT * FROM honglamhuong.vt_news_category where parent_id is not null')->queryAll();
        } else {
            return;
        }
      
        foreach ($data as $item) {
            $model = new ArticleCategory;
            $item = (object) $item;
            
            $model->id = $item->id;
            $model->parent_id = $item->parent_id;
            $model->name = $item->name;
            $model->slug = $item->slug;
            $model->h1 = $item->h1;
            $model->meta_keywords = $item->meta_keyword;
            $model->description = $item->description;
            $model->meta_description = $item->meta_description;
            $model->meta_title = $item->meta_title;
            $model->page_title = $item->meta_title;
            
            $model->sort_order = $item->category_order;
            $model->is_active = $item->status;
            $model->created_by = 'admin';
            $model->updated_by = 'admin';
            $model->created_at = strtotime($item->created_date);
            $model->updated_at = strtotime($item->updated_date);

            $model->long_description = $item->top_description;
            
            $model->image = $item->image;
            
            $model->image_path = FileUtils::generatePath($model->created_at, Yii::$app->params['images_folder']);
            
            $old_image_path = 'news_category' . self::getOldImagePath($item->id, $item->created_date);
                
            $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $model->image_path;

            $copyResult = FileUtils::copyImage([
                'imageName' => $model->image,
                'fromFolder' => self::IMG_HOST . $old_image_path,
                'toFolder' => $targetFolder,
                'resize' => array_values(ArticleCategory::$image_resizes),
                'removeInputImage' => false,
                'createWatermark' => false,
                'ignoreIfExists' => true,
            ]);
            
            if ($copyResult['success']) {
                $model->image = $copyResult['imageName'];
            } else {
                var_dump($copyResult);
            }

            $model->long_description = FileUtils::copyContentImages([
                'content' => $model->long_description,
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => false,
                'ignoreIfExists' => false,
            ]);
            
            if (!ArticleCategory::findOne($model->id)) {
                if ($model->save()) {
                    echo "Migrated model id = $model->id successfully!<br><br>";
                } else {
                    echo "Failed to migrate model id = $model->id. ";
                    var_dump($model->errors);
                    echo '<br><br>';
                }
            } else {
                echo "Model id = $model->id has already existed in database!<br><br>";
            }
        }
    }
    
    public function actionArticle($offset, $limit)
    {
        $conn = self::connect();
        $conn->open();
        
        $data = $conn
            ->createCommand("SELECT * FROM honglamhuong.vt_news limit $limit offset $offset")
            ->queryAll();
        
        foreach ($data as $item) {
            $model = new Article;
            $item = (object) $item;
            
            $model->id = $item->id;
            $model->category_id = $item->news_category_id;
            $model->name = $item->title;
            $model->slug = $item->slug;
            $model->h1 = $item->h1;
            $model->meta_keywords = $item->meta_keyword;
            $model->description = $item->description;
            $model->meta_description = $item->meta_description;
            $model->meta_title = $item->meta_title == '' ? $item->title : $item->meta_title;
            $model->page_title = $item->meta_title == '' ? $item->title : $item->meta_title;
            
            $model->view_count = $item->views_count;
            $model->comment_count = $item->comments_count;
            $model->is_active = $item->status;
            $model->created_by = $item->created_user;
            $model->updated_by = $item->updated_user;
            $model->created_at = strtotime($item->created_date);
            $model->updated_at = strtotime($item->updated_date);
            $model->published_at = strtotime($item->activated_date);

            $model->content = $item->content;
            
            $model->image = $item->image;
            
            $model->image_path = FileUtils::generatePath($model->created_at, Yii::$app->params['images_folder']);
            
            $old_image_path = 'news' . self::getOldImagePath($item->id, $item->created_date);
                
            $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $model->image_path;

            $copyResult = FileUtils::copyImage([
                'imageName' => $model->image,
                'fromFolder' => self::IMG_HOST . $old_image_path,
                'toFolder' => $targetFolder,
                'resize' => array_values(Article::$image_resizes),
                'removeInputImage' => false,
                'createWatermark' => false,
                'ignoreIfExists' => false,
            ]);
            
            if ($copyResult['success']) {
                $model->image = $copyResult['imageName'];
            } else {
                var_dump($copyResult);
            }

            $model->content = FileUtils::copyContentImages([
                'content' => $model->content,
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => false,
                'ignoreIfExists' => false,
            ]);
            
            
            if (!Article::findOne($model->id)) {
                if ($model->save()) {
                    echo "Migrated model id = $model->id successfully!<br><br>";
                } else {
                    echo "Failed to migrate model id = $model->id. ";
                    var_dump($model->errors);
                    echo '<br><br>';
                }
            } else {
                echo "Model id = $model->id has already existed in database!<br><br>";
            }
        }
    }
    
    public function actionProduct($offset, $limit)
    {
        $conn = self::connect();
        $conn->open();
        
        $data = $conn
            ->createCommand("SELECT * FROM honglamhuong.vt_products limit $limit offset $offset")
            ->queryAll();
        
        foreach ($data as $item) {
            $model = new Product;
            $item = (object) $item;
            
            $model->id = $item->id;
            $model->category_id = null;
            $model->name = $item->title;
            $model->slug = $item->slug;
            $model->h1 = $item->h1;
            $model->meta_keywords = $item->meta_keyword;
            $model->description = $item->description;
            $model->meta_description = $item->meta_description;
            $model->meta_title = $item->meta_title == '' ? $item->title : $item->meta_title;
            $model->page_title = $item->meta_title == '' ? $item->title : $item->meta_title;
            
            $model->view_count = $item->views_count;
            $model->comment_count = $item->comments_count;
            $model->is_active = $item->status;
            $model->created_by = $item->created_user;
            $model->updated_by = $item->updated_user;
            $model->created_at = strtotime($item->created_date);
            $model->updated_at = strtotime($item->updated_date);
            $model->published_at = strtotime($item->activated_date);

            $model->price = $item->price;
            $model->original_price = $item->original_price;
            $model->code = $item->code;
            
            $model->content = $item->content;
            
            $model->image = $item->image;
            
            $model->image_path = FileUtils::generatePath($model->created_at, Yii::$app->params['images_folder']);
            
            $old_image_path = 'products' . self::getOldImagePath($item->id, $item->created_date);
                
            $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $model->image_path;

            $copyResult = FileUtils::copyImage([
                'imageName' => $model->image,
                'fromFolder' => self::IMG_HOST . $old_image_path,
                'toFolder' => $targetFolder,
                'resize' => array_values(Product::$image_resizes),
                'removeInputImage' => false,
                'createWatermark' => false,
                'ignoreIfExists' => false,
            ]);
            
            if ($copyResult['success']) {
                $model->image = $copyResult['imageName'];
            } else {
                var_dump($copyResult);
            }

            $model->content = FileUtils::copyContentImages([
                'content' => $model->content,
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => false,
                'ignoreIfExists' => false,
            ]);
            
            
            if (!Product::findOne($model->id)) {
                if ($model->save()) {
                    echo "Migrated model id = $model->id successfully!<br><br>";
                } else {
                    echo "Failed to migrate model id = $model->id. ";
                    var_dump($model->errors);
                    echo '<br><br>';
                }
            } else {
                echo "Model id = $model->id has already existed in database!<br><br>";
            }
        }
    }
    
    public function actionUser()
    {
        $conn = self::connect();
        $conn->open();
        
        $data = $conn
            ->createCommand("SELECT * FROM honglamhuong.user")
            ->queryAll();
        
        foreach ($data as $item) {
            $model = new User;
            $item = (object) $item;
            
            $model->id = $item->id;
            $model->username = $item->username;
            $model->auth_key = $item->auth_key;
            $model->password_hash = $item->password_hash;
            $model->password_reset_token = $item->password_reset_token;
            $model->email = $item->email;
            $model->status = $item->status;
            $model->created_at = $item->created_at;
            $model->updated_at = $item->updated_at;
            
            if (!User::findOne($model->id) && !User::findOne(['username' => $model->username])) {
                if ($model->save(false)) {
                    echo "Migrated model id = $model->id successfully!<br><br>";
                } else {
                    echo "Failed to migrate model id = $model->id. ";
                    var_dump($model->errors);
                    echo '<br><br>';
                }
            } else {
                echo "Model id = $model->id has already existed in database!<br><br>";
            }
        }
    }
}
