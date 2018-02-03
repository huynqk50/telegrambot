<?php

namespace frontend\models;

use common\models\MyActiveRecord;

/**
 * Description of Category
 *
 * @author Tran Van Quyet <quyettvq at gmail.com>
 */
abstract class Category extends MyActiveRecord {
    
    abstract static function indexData();

    public static function findOneBySlug($slug)
    {
        $data = static::indexData();
        foreach ($data as $item) {
            if ($item->slug == $slug) {
                return $item;
            }
        }
        
        return self::find()->where(['slug' => $slug])->oneActive();
    }
    
    public static function findOneByType($type)
    {
        $data = static::indexData();
        foreach ($data as $item) {
            if ($item->type == $type) {
                return $item;
            }
        }
        
        return self::find()->where(['type' => $type])->oneActive();
    }
    
    public static function findOneById($id)
    {
        $data = static::indexData();
        return isset($data[$id])
            ? $data[$id]
            : self::find()->where(['id' => $id])->oneActive();
    }

    public $_parent = 1;
    public function findParent()
    {
        if ($this->parent_id === null) {
            return false;
        }
        
        if ($this->_parent === 1) {
            $this->_parent = self::findOneById($this->parent_id);
        }
        
        return $this->_parent;
    }
    
    public $_children = 1;
    public function findChildren()
    {
        if ($this->_children === 1) {
            $this->_children = [];
            $items = static::indexData();
            foreach ($items as $item) {
                if ($item->parent_id == $this->id) {
                    $this->_children[] = $item;
                }
            }
        }
        
        return $this->_children;
    }
    
}
