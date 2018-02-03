<?php
namespace common\models;

class SlideshowItem extends MyActiveRecord {
    const IMAGE_SMALL = '[200,200]';
    const IMAGE_MEDIUM = '[500,500]';
    const IMAGE_LARGE = '[700,700]';
    const IMAGE_HUGE = '[1200,1200]';
    
    
    public static $image_resizes = [
        self::IMAGE_TINY,
        self::IMAGE_SMALL,
        self::IMAGE_MEDIUM,
        self::IMAGE_LARGE,
        self::IMAGE_HUGE,
    ];
    
}
