<?php

namespace common\models;

/**
 * Description of Currency
 *
 * @author quyet
 */
class Currency {
    public static function vnd($number)
    {
        return number_format($number, 0, ',', '.') . ' VNĐ';
    }
}
