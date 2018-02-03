<?php

namespace common\utils;

/**
 * Description of Json
 *
 * @author Tran Van Quyet <quyettvq at gmail.com>
 */
class Json {
    public static function decode($json, $assoc = TRUE){
        $json = str_replace("\n","\\n",$json);
        $json = str_replace("\r","",$json);
        $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
        $json = preg_replace('/(,)\s*}$/','}',$json);
//        $json = utf8_encode($json);
        return json_decode($json,$assoc);
    }
}
