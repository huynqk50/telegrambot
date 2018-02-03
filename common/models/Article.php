<?php

namespace common\models;

class Article extends MyActiveRecord {
    const STATUS_HOT = 1;
    const STATUS_FEATURED = 2;

    public static $statuses = [
        self::STATUS_HOT => 'Tin nóng',
        self::STATUS_FEATURED => 'Tin nổi bật',
    ];
}