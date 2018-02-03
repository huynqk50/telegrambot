<?php

namespace common\models;
use common\utils\StringUtils;
use common\utils\FileUtils;
use Yii;
use yii\db\ActiveRecord;

class MyActiveRecord extends ActiveRecord {
    
    const IMAGE_VERY_TINY = '[50,50]';
    const IMAGE_TINY = '[100,100]';
    const IMAGE_SMALL = '[200,200]';
    const IMAGE_MEDIUM = '[300,300]';
    const IMAGE_LARGE = '[400,400]';
    const IMAGE_HUGE = '[500,500]';
    
    const BANNER_TINY = '[300,300]';
    const BANNER_SMALL = '[400,400]';
    const BANNER_MEDIUM = '[500,500]';
    const BANNER_LARGE = '[600,600]';
    const BANNER_HUGE = '[700,700]';
    
    public static $image_resizes = [
        self::IMAGE_VERY_TINY,
        self::IMAGE_TINY,
        self::IMAGE_SMALL,
        self::IMAGE_MEDIUM,
        self::IMAGE_LARGE,
        self::IMAGE_HUGE,
    ];
    
    public static $banner_resizes = [
        self::BANNER_TINY,
        self::BANNER_SMALL,
        self::BANNER_MEDIUM,
        self::BANNER_LARGE,
        self::BANNER_HUGE,
    ];
    
    public $_image; 
    public function getImage($suffix = null, $refresh = false) 
    { 
       if ($this->_image === null || $refresh == true) { 
           $this->_image = FileUtils::getImage([ 
               'imageName' => $this->image, 
               'imagePath' => $this->image_path, 
               'imagesFolder' => Yii::$app->params['images_folder'], 
               'imagesUrl' => Yii::$app->params['images_url'], 
               'suffix' => $suffix, 
               'defaultImage' => Yii::$app->params['default_image'] 
           ]); 
       } 
       return $this->_image; 
   }
        
    /**
    * function ->getBanner ($suffix, $refresh)
    */
    public $_banner;
    public function getBanner($suffix = null, $refresh = false)
    {
        if ($this->_banner === null || $refresh == true) {
            $this->_banner = FileUtils::getImage([
                'imageName' => $this->banner,
                'imagePath' => $this->image_path,
                'imagesFolder' => Yii::$app->params['images_folder'],
                'imagesUrl' => Yii::$app->params['images_url'],
                'suffix' => $suffix,
                'defaultImage' => Yii::$app->params['default_image']
            ]);
        }
        return $this->_banner;
    }
    
    public $a = '';

    public function a($params = [], $content = null)
    {
        $result = "<a href=\"{$this->getLink()}\" title=\"" . str_replace("\"", "'", $this->name) . "\"";
        $has_schema = false;
//        if (is_array($params)) {
            foreach ($params as $attr => $val) {
//                if ($attr == 0) {
//                    $result .= "class=\"$val\"";
//                } else if ($attr == 1) {
//                    $result .= "id=\"$val\"";
//                } else {
                    $result .= " $attr=\"$val\"";
//                }
                if (!$has_schema && in_array($attr, ['itemprop', 'itemscope', 'itemtype'])) {
                    $has_schema = true;
                }
            }
//        } else if ($params != '') {
//            $result .= "class=\"$params\"";
//        }
        if (!$has_schema) {
            $result .= " itemprop=\"url\"";
        }
        if ($content !== null) {
            $result .= ">$content</a>";
        } else {
            $result .= ">$this->name</a>";
        }
        return $result;
    }
    
    public $img = '';

    public function img($params = [], $suffix = null)
    {
        $src = isset($params['src']) ? $params['src'] : ($suffix == null ? $this->getImage() : $this->getImage($suffix, true));
        $name = str_replace("\"", "'", isset($this->name) ? $this->name : (isset($this->caption) ? $this->caption : 'image'));
        
        $result = "<img src=\"{$src}\" title=\"$name\" alt=\"$name\"";
        
        $has_schema = false;
        foreach ($params as $attr => $val) {
            $result .= " $attr=\"$val\"";
            if (!$has_schema && in_array($attr, ['itemprop', 'itemscope', 'itemtype'])) {
                $has_schema = true;
            }
        }
        if (!$has_schema) {
            $result .= " itemprop=\"image\"";
        }
        
        $result .= '>';
        
        return $result;
    }

    public function banner($params = [], $suffix = null)
    {
        if ($suffix !== null) {
            $params['src'] = $this->getBanner($suffix, true);
        } else {
            $params['src'] = $this->getBanner();
        }
        return $this->img($params);
    }
    
    public function auth()
    {
        $user = User::find()->where(['username' => $this->created_by])->one();
        if ($user) {
            return $user->alias;
        }
        return 'Admin';
    }
    
    public function desc($column = 'description', $length = 34)
    {
        return StringUtils::summaryText($this->$column, $length);
    }
    
    public function date($column = 'published_at', $format = 'd-m-Y H:i')
    {
        return date($format, $this->$column);
    }
    
    public function contentWithAdsense($adsense, $number = 2, $str_find = '</p>')
    {
        $content = $this->content;
        $length = strlen($content);
        
        for ($i = 1; $i <= $number; $i++) {
            $start = (int) floor(($length / $number) * ($i - 0.75));
            $pos = strpos($content, $str_find, $start);
            $content = substr_replace($content, "$str_find $adsense", $pos, strlen($str_find));
        }
        
        return $content;
    }
    
    /** 
    * @inheritdoc 
    * @return ArticleQuery the active query used by this AR class. 
    */ 
    public static function find() 
    {
        return new MyActiveQuery(get_called_class());
    }
    
    public function getAllChildren()
    {
        $allChildren = $this->children;
        foreach ($allChildren as $item) {
            $allChildren = array_merge($allChildren, $item->allChildren);
        }
        $query = static::find();
        $query->where(['in', 'id', \yii\helpers\ArrayHelper::getColumn($allChildren, 'id')]);
        $query->multiple = true;
        return $query;
    }
    
}
