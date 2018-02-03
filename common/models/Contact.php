<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 1/10/2017
 * Time: 7:17 PM
 */

namespace common\models;


class Contact extends MyActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_SEEN = 2;
    const STATUS_REPLIED = 3;

    public static $statues = [
        self::STATUS_NEW => 'Mới',
        self::STATUS_SEEN => 'Đã xem',
        self::STATUS_REPLIED => 'Đã trả lời',
    ];
}