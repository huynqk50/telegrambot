<?php
namespace common\utils;

class StringUtils {
    public static function summaryText($str, $len = 30, $more = '...'){
        $wordArr = explode(' ',strip_tags($str));
        if(count($wordArr)>$len){
            $str='';
            for($i=0;$i<$len;$i++){
                $str.=$wordArr[$i] . ' ';
            }
            return trim($str,' ') . $more;
        }
        return $str;
    }
    
}