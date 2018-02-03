<?php
namespace common\utils;

use DateTime;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateUtil
 *
 * @author huynq
 */
class DateUtil {
    //put your code here
    
    public static function getNextMonthDate($date) {
        $d = new DateTime($date);
        return $d->modify('1 month')->format('Y-m-d');
    }
    
    public static function getLastMonthDate($date) {
        $d = new DateTime($date);
        return $d->modify('-1 month')->format('Y-m-d');
    }
    
    public static function getNextDay($date, $format = '') {
        $f = $format == '' ? 'Y-m-d' : $format;
        $d = new DateTime($date);
        return $d->modify('1 day')->format($f);
    }
    
    public static function increaseDay($date, $interval, $format = '') {
         $f = $format == '' ? 'Y-m-d' : $format;
        $d = new DateTime($date);
        return $d->modify($interval.' day')->format($f);
    }
    
    public static function decreaseDay($date, $interval, $format = '') {
         $f = $format == '' ? 'Y-m-d' : $format;
        $d = new DateTime($date);
        return $d->modify('-'.$interval.' day')->format($f);
    }
    
    public static function getBeforeDay($date, $format = '') {
        $f = $format == '' ? 'Y-m-d' : $format;
        $d = new DateTime($date);
        return $d->modify('-1 day')->format($f);
    }
    
    public static function getStartThisWeek($date) {
        
        // bat dau tu t4
        $d = new DateTime($date);
        $d1 = $d->modify("this tuesday")->format('Y-m-d');
       if ($date > $d1 ) {
        return $d->modify('last week')->modify("9 day")->format('Y-m-d');
       } else {
           return $d->modify('last week')->modify("2 day")->format('Y-m-d');
       }
    }
    public static function getEndThisWeek($date) {
//        $monday = strtotime('last monday', strtotime($date));
        // tính từ t4 tới hết t3
        $d = new DateTime($date);
        return $d->modify('last week')->modify("15 day")->format('Y-m-d');
    }
    
    public static function getEndOfDay($date) {
        $d = new DateTime($date);
        return $d->modify("1 day")->modify('-1 second')->format('Y-m-d H:i:s');
    }
    
    public static function dateDiff($d1, $d2, $diffFormat = "%a") {
        $datetime1 = date_create($d1);
        $datetime2 = date_create($d2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($diffFormat);
    }
}
