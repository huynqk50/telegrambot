<?php

namespace backend\models;

use common\utils\FileUtils;
use common\utils\Dump;
use Yii;
use frontend\models\UrlParam;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $label
 * @property string $slug
 * @property string $old_slugs
 * @property string $content
 * @property string $description
 * @property string $image
 * @property string $image_path
 * @property string $page_title
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $h1
 * @property integer $view_count
 * @property integer $like_count
 * @property integer $comment_count
 * @property integer $share_count
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $auth_alias
 * @property integer $is_hot
 * @property integer $sort_order
 * @property integer $status
 * @property string $long_description
 * @property integer $published_at
 * @property integer $is_active
 * @property integer $type
 *
 * @property ArticleCategory $category
 * @property ArticleRelated[] $articleRelateds
 * @property ArticleRelated[] $articleRelateds0
 * @property ArticleToTag[] $articleToTags
 */
class Article extends \common\models\Article
{
    
    /**
    * function ->getLink ()
    */
//    public $_link;
//    public function getLink ()
//    {
//        if ($this->_link === null) {
//            $this->_link = Yii::$app->params['frontend_url']
//                . Yii::$app->frontendUrlManager->createUrl(['article/index', 'slug' => $this->slug]);
//        }
//        return $this->_link;
//    }

    public $_link;
    public function getLink()
    {
        if ($this->_link == null) {
            if ($category = $this->category) {
                if ($parent_category = $category->parent) {
                    $this->_link = Yii::$app->params['frontend_url'] .
                        Yii::$app->frontendUrlManager->createUrl([
                        'article/index',
                        UrlParam::SLUG => $this->slug,
                        UrlParam::CATEGORY_SLUG => $category->slug,
                        UrlParam::PARENT_SLUG => $parent_category->slug
                    ], true);
                } else {
                    $this->_link = Yii::$app->params['frontend_url'] .
                        Yii::$app->frontendUrlManager->createUrl([
                        'article/index',
                        UrlParam::SLUG => $this->slug,
                        UrlParam::CATEGORY_SLUG => $category->slug
                    ], true);
                }
            } else {
                $this->_link = Yii::$app->params['frontend_url'] .
                    Yii::$app->frontendUrlManager->createUrl([
                    'article/index',
                    UrlParam::SLUG => $this->slug,
                ], true);
            }
        }

        return $this->_link;
    }

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new Article();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'Article';
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            $model->created_at = $now;
            $model->created_by = $username;
            $model->published_at = strtotime($model->published_at);
                

            $model->image_path = FileUtils::generatePath($now, Yii::$app->params['images_folder']);

            $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $model->image_path;
            
            if (!empty($data['article-image'])) {
                $copyResult = FileUtils::copyImage([
                    'imageName' => $model->image,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$image_resizes),
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $model->image = $copyResult['imageName'];
                }
            }
                    
            $model->content = FileUtils::copyContentImages([
                'content' => $model->content,
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
                    
            $model->long_description = FileUtils::copyContentImages([
                'content' => $model->long_description,
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
            if ($model->save()) {
                if ($log) {
                    $log->object_pk = $model->id;
                    $log->is_success = 1;
                    $log->save();
                }
                return $model;
            }
            Dump::errors($model->errors);
            return;
        }
        return false;
    }
    
    /**
    * function ->update2 ($data)
    */
    public function update2 ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;   
        if ($this->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Update';
                $log->object_class = 'Article';
                $log->object_pk = $this->id;
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            $this->updated_at = $now;
            $this->updated_by = $username;
            $this->published_at = strtotime($this->published_at);
            if ($this->slug != $this->getOldAttribute('slug')) {
                $old_slugs_arr = json_decode($this->old_slugs, true);
                is_array($old_slugs_arr) or $old_slugs_arr = array();
                $old_slugs_arr[$now] = $this->getOldAttribute('slug');
                $this->old_slugs = json_encode($old_slugs_arr);
            }
                  
            if ($this->image_path == null || trim($this->image_path) == '' || !is_dir(Yii::$app->params['images_folder'] . $this->image_path)) {
                $this->image_path = FileUtils::generatePath($now, Yii::$app->params['images_folder']);
            }
            
            $targetFolder = Yii::$app->params['images_folder'] . $this->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $this->image_path;
            
            if (!empty($data['article-image'])) {
                $copyResult = FileUtils::updateImage([
                    'imageName' => $this->image,
                    'oldImageName' => $this->getOldAttribute('image'),
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$image_resizes),
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $this->image = $copyResult['imageName'];
                }
            }
            $this->content = FileUtils::updateContentImages([
                'content' => $this->content,
                'oldContent' => $this->getOldAttribute('content'),
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
            $this->long_description = FileUtils::updateContentImages([
                'content' => $this->long_description,
                'oldContent' => $this->getOldAttribute('long_description'),
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
            
            if ($this->save()) {
                if ($log) {
                    $log->is_success = 1;
                    $log->save();
                }
                return true;
            }
        }
        return false;
    }
    
    /**
    * function ->delete ()
    */
    public function delete ()
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;    
        if ($log = new UserLog()) {
            $log->username = $username;
            $log->action = 'Delete';
            $log->object_class = 'Article';
            $log->object_pk = $this->id;
            $log->created_at = $now;
            $log->is_success = 0;
            $log->save();
        }
        if(parent::delete()) {
            if ($log) {
                $log->is_success = 1;
                $log->save();
            }
            if ($this->image_path != '') {
                $targetFolder = Yii::$app->params['images_folder'] . $this->image_path;
                $targetUrl = Yii::$app->params['images_url'] . $this->image_path;
            
                FileUtils::updateImage([
                    'imageName' => '',
                    'oldImageName' => $this->image,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$image_resizes),
                ]);
                
                FileUtils::updateContentImages([
                    'content' => '',
                    'oldContent' => $this->content,
                    'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'toUrl' => $targetUrl,
                ]);
                
                FileUtils::updateContentImages([
                    'content' => '',
                    'oldContent' => $this->long_description,
                    'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'toUrl' => $targetUrl,
                ]);
                
            }
            
            return true;
        }
        return false;
    }

    /**
     * @vars
     */
    public $related_ids;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'view_count', 'like_count', 'comment_count', 'share_count', 'is_hot', 'sort_order', 'status', 'is_active', 'type'], 'integer'],
            [['name', 'slug', 'created_at', 'created_by', 'published_at'], 'required'],
            [['category_id', 'content', 'page_title', 'meta_title', 'h1', 'meta_keywords', 'meta_description', 'description'], 'required'],
            [['content', 'long_description'], 'string'],
            [['created_at', 'updated_at', 'published_at'], 'safe'],
            [['name', 'label', 'slug', 'created_by', 'updated_by', 'auth_alias'], 'string', 'max' => 255],
            [['old_slugs'], 'string', 'max' => 2000],
            [['description', 'image', 'image_path', 'page_title', 'meta_title', 'meta_keywords', 'meta_description', 'h1'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['related_ids'], 'each', 'rule' => ['integer']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Danh mục',
            'name' => 'Tên',
            'label' => 'Nhãn',
            'slug' => 'Slug',
            'old_slugs' => 'Old Slugs',
            'content' => 'Nội dung',
            'description' => 'Mô tả',
            'image' => 'Ảnh đại diện',
            'image_path' => 'Image Path',
            'page_title' => 'Tiêu đề trang',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'h1' => 'H1',
            'view_count' => 'View Count',
            'like_count' => 'Like Count',
            'comment_count' => 'Comment Count',
            'share_count' => 'Share Count',
            'created_at' => 'Thêm mới lúc',
            'updated_at' => 'Cập nhật lúc',
            'created_by' => 'Thêm mới bởi',
            'updated_by' => 'Cập nhật bởi',
            'auth_alias' => 'Auth Alias',
            'is_hot' => 'Bài HOT',
            'sort_order' => 'Thứ tự sắp xếp',
            'status' => 'Trạng thái',
            'long_description' => 'Mô tả chi tiết',
            'published_at' => 'Công khai lúc',
            'is_active' => 'Kích hoạt',
            'type' => 'Phân loại',
            'related_ids' => 'Bài liên quan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleRelateds()
    {
        return $this->hasMany(ArticleRelated::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleRelateds0()
    {
        return $this->hasMany(ArticleRelated::className(), ['related_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleToTags()
    {
        return $this->hasMany(ArticleToTag::className(), ['article_id' => 'id']);
    }
}
