<?php
namespace common\utils;

class Common {
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
    public static function getVTImageByDate($id, $date, $imageName, $size = '') {
        $createDate = strtotime($date);
        $dateFolder = date('Y', $createDate) . date('m', $createDate);
//        $imageName = ( $size == '' ? $imageName : $size.$imageName ); 
        if ($size != '') {
            $imageName = $size.'-'.$imageName;
        }
        return $dateFolder . "/" . $id . "/" . $imageName;
    }  
    
    public static function checkUrlExist($url){
        $url_headers = @get_headers($url);
        if($url_headers[0] == 'HTTP/1.1 404 Not Found') {
            $exists = false;
        }
        else {
            $exists = true;
        }
    }
    
    public static function vn_str_filter ($str){

       $unicode = array(

           'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

           'd'=>'đ',

           'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

           'i'=>'í|ì|ỉ|ĩ|ị',

           'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

           'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

           'y'=>'ý|ỳ|ỷ|ỹ|ỵ',

           'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

           'D'=>'Đ',

           'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

           'I'=>'Í|Ì|Ỉ|Ĩ|Ị',

           'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

           'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

           'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

       );

      foreach($unicode as $nonUnicode=>$uni){

           $str = preg_replace("/($uni)/i", $nonUnicode, $str);

      }

       return $str;

   }
        
    
    public static function generateRandomString($length = 50) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getWeekdayStamp($date, $format=', d/m/Y H:i', $wd=true){
        if(!is_numeric($date)){
            $date=strtotime($date);
        }
        if($wd){
            switch (date('w',$date)){
                case 0:
                    $weekday = 'Chủ nhật';
                    break;
                case 1:
                    $weekday = 'Thứ hai';
                    break;
                case 2:
                    $weekday = 'Thứ ba';
                    break;
                case 3:
                    $weekday = 'Thứ tư';
                    break;
                case 4:
                    $weekday = 'Thứ năm';
                    break;
                case 5:
                    $weekday = 'Thứ sáu';
                    break;
                case 6:
                    $weekday = 'Thứ bảy';
                    break;
            }
        }else{
            $weekday='';
        }
        return $weekday . date($format, $date) ;
    }

    public static function getCurrentWeekday($arr=['d'=>', ','m'=>'/','Y'=>'/']) {
        //date_default_timezone_set('Asia/Ho_Chi_Minh');
        $weekday = date("l");
        $weekday = strtolower($weekday);
        switch($weekday) {
            case 'monday':
                $weekday = 'Thứ 2';
                break;
            case 'tuesday':
                $weekday = 'Thứ 3';
                break;
            case 'wednesday':
                $weekday = 'Thứ 4';
                break;
            case 'thursday':
                $weekday = 'Thứ 5';
                break;
            case 'friday':
                $weekday = 'Thứ 6';
                break;
            case 'saturday':
                $weekday = 'Thứ 7';
                break;
            default:
                $weekday = 'Chủ nhật';
                break;
        }
        return $weekday.$arr['d'].date('d').$arr['m'].date('m').$arr['Y'].date('Y');
    }
    

    /**
     *  
     */

    public static function getOperatorName($identifier) {
        $threeDigit = substr($identifier, 0, 3);
        //Check for Viettel
        if ($threeDigit == '096' ||$threeDigit == '097' || $threeDigit == '098' || $identifier == '0163' || $identifier == '0164' || $identifier == '0165' || $identifier == '0166' || $identifier == '0167' || $identifier == '0168' || $identifier == '0169') {
            return 'Viettel';
        }
        if ($threeDigit == '090' || $threeDigit == '093' || $identifier == '0120' || $identifier == '0121' || $identifier == '0122' || $identifier == '0126' || $identifier == '0128') {
            return 'Mobifone';
        }
        if ($threeDigit == '091' || $threeDigit == '094' || $identifier == '0123' || $identifier == '0124' || $identifier == '0125' || $identifier == '0127' || $identifier == '0129') {
            return 'Vinaphone';
        }
        if ($threeDigit == '092' || $identifier == '0188') {
            return 'Vietnamobile';
        }
        if ($threeDigit == '099' || $identifier == '0199') {
            return 'Gmobile';
        }
        return '';
    }

    public static function removeFolderAndContent($dir) {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                Common::removeFolderAndContent($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dir);
    }

    public static function get_time_to_days_ago($time, $detect) {
        if ($detect == 3) {
            $publish_date = date('d/m/Y', $time);
            return $publish_date;
        } else if ($detect == 1 || $detect == 2) {
            $currenttime = time();
            $timediff = $currenttime - $time;
            $oneday = 60 * 60 * 24;
            $dayspassed = floor($timediff / $oneday);
            $week = floor($dayspassed / 7);

            if ($dayspassed == "0") {
                $mins = floor($timediff / 60);
                if ($mins == "0") {
                    $secs = floor($timediff);
                    if ($secs == "1") {
                        return "1 giây trước";
                    } else {
                        return $secs . " giây trước";
                    }
                } elseif ($mins == "1") {
                    return '1 phút trước';
                } elseif ($mins < "60") {
                    return $mins . " phút trước";
                } elseif ($mins == "60") {
                    return '1 giờ trước';
                } else {
                    $hours = floor($mins / 60);
                    return $hours . " giờ trước";
                }
            } else {

                if ($dayspassed < 7) {
                    return $dayspassed . " ngày trước";
                } else if ($week < 4) {

                    return $week . " tuần trước";
                } else {

                    $date = getdate($time);
                    $arr = Common::getWeekDay($date["wday"]);
                    $publish_date = $arr["label"] . ', ' . date('d/m/Y H:i', $time);

                    return $publish_date;
                }
            }
        } else {
            $date = getdate($time);
            $arr = Common::getWeekDay($date["wday"]);
            $publish_date = $arr["label"] . ', ' . date('d/m/Y H:i', $time);

            return $publish_date;
        }
    }

   

    function bigintval($value) {
        $value = trim($value);
        if (ctype_digit($value)) {
            return $value;
        }
        $value = preg_replace("/[^0-9](.*)$/", '', $value);
        if (ctype_digit($value)) {
            return $value;
        }
        return 0;
    }

    function storeType($type) {
        $str_type = 'Cơ bản';
        if ($type == 1) {
            $str_type = 'Chuyên Nghiệp';
        }
        return $str_type;
    }

    public static function change($text) {
        $chars = array("a", "A", "e", "E", "o", "O", "u", "U", "i", "I", "d", "D", "y", "Y");
        $uni[0] = array("á", "à", "ạ", "ả", "ã", "â", "ấ", "ầ", "ậ", "ẩ", "ẫ", "ă", "ắ", "ằ", "ặ", "ẳ", "ẵ");
        $uni[1] = array("Á", "À", "Ạ", "Ả", "Ã", "Â", "Ấ", "Ầ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ắ", "Ằ", "Ặ", "Ẳ", "Ẵ");
        $uni[2] = array("é", "è", "ẹ", "ẻ", "ẽ", "ê", "ế", "ề", "ệ", "ể", "ễ");
        $uni[3] = array("É", "È", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ế", "Ề", "Ệ", "Ể", "Ễ");
        $uni[4] = array("ó", "ò", "ọ", "ỏ", "õ", "ô", "ố", "ồ", "ộ", "ổ", "ỗ", "ơ", "ớ", "ờ", "ợ", "ở", "ỡ");
        $uni[5] = array("Ó", "Ò", "Ọ", "Ỏ", "Õ", "Ô", "Ố", "Ồ", "Ộ", "Ổ", "Ỗ", "Ơ", "Ớ", "Ờ", "Ợ", "Ở", "Ỡ");
        $uni[6] = array("ú", "ù", "ụ", "ủ", "ũ", "ư", "ứ", "ừ", "ự", "ử", "ữ");
        $uni[7] = array("Ú", "Ù", "Ụ", "Ủ", "Ũ", "Ư", "Ứ", "Ừ", "Ự", "Ử", "Ữ");
        $uni[8] = array("í", "ì", "ị", "ỉ", "ĩ");
        $uni[9] = array("Í", "Ì", "Ị", "Ỉ", "Ĩ");
        $uni[10] = array("đ");
        $uni[11] = array("Đ");
        $uni[12] = array("ý", "ỳ", "ỵ", "ỷ", "ỹ");
        $uni[13] = array("Ý", "Ỳ", "Ỵ", "Ỷ", "Ỹ");

        for ($i = 0; $i <= 13; $i++) {
            $text = str_replace($uni[$i], $chars[$i], $text);
        }
        return $text;
    }

    public static function generate_slug($string) {
        $string = Common::change($string);
        $string = preg_replace("/(^|&\S+;)|(<[^>]*>)/U", "", $string);
        $string = strtolower(preg_replace('/[\s\-]+/', '-', trim(preg_replace('/[^\w\s\-]/', '', $string))));
        $slug = preg_replace("/[^A-Za-z0-9\-]/", "", $string);
        return $slug;
    }

    function generate_slug_youtube($string) {
        $string = Common::change($string);
        $string = preg_replace("/(^|&\S+;)|(<[^>]*>)/U", "", $string);
        $string = strtolower(preg_replace('/[\s\-]+/', '+', trim(preg_replace('/[^\w\s\-]/', '', $string))));
        $slug = preg_replace("/[^A-Za-z0-9\-]/", "+", $string);
        return $slug;
    }

    static function subStru($str, $from, $len) { // cắt chuỗi
        $len_sub = $len - $from;
        if (strlen($str) > $len_sub) {
            $len = $len - 3;
            $str1 = preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' . '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s', '$1', $str) . '...';
        } else {
            $str1 = preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' . '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s', '$1', $str);
        }
        return $str1;
    }

    function gen_title_kodau($string) {
        $string = Common::change($string);
        return $string;
    }

    //Ký tự ngẫu nhiên
    function random($sokytu) {
        $mangso = "123456789";
        $mangchu = "-_=QqWwEeRrTtYyPpAaSsDdFfGgHhKkZzXxCcVvBbNnMm";
        $kytu_ngaunhien = "";
        for ($i = 0; $i < $sokytu; $i++) {
            $chon_mang = rand(1, 2);
            if ($chon_mang == 1)
                $kytu_ngaunhien = $kytu_ngaunhien . $mangso[rand(0, 8)];
            else
                $kytu_ngaunhien = $kytu_ngaunhien . $mangchu[rand(0, 20)];
        }
        return $kytu_ngaunhien;
    }

   
    /**
     * sắp xếp mảng
     * 
     * @param mixed $array
     * @param mixed $field
     * @param mixed $type
     */
    static function multiSort($array, $field, $type = 1) {
        $array_sort = array();
        if ($array) {
            foreach ($array as $key => $row) {
                $array_sort[$key] = isset($array[$field]) ?$array[$field] : 0;
            }
            if ($type = 1)
                array_multisort($array_sort, SORT_DESC, $array);
            else
                array_multisort($array_sort, SORT_ASC, $array);
        }
        return $array;
    }

    

    static function getImageError($type = 'small') {
        if ($type == 'medium') {
            return Yii::app()->params['static_url'] . '/images/no_photo_x_small.gif';
        }
        return Yii::app()->params['static_url'] . '/images/no_photo_x_small.gif';
    }

    /**
     * replace ký tự đầu tiên tìm thấy
     * 
     * @param mixed $str_pattern
     * @param mixed $str_replacement
     * @param mixed $string
     * @return mixed
     */
    static function str_replace_once($str_pattern, $str_replacement, $string) {

        if (strpos($string, $str_pattern) !== false) {
            $occurrence = strpos($string, $str_pattern);
            return substr_replace($string, $str_replacement, strpos($string, $str_pattern), strlen($str_pattern));
        }

        return $string;
    }

    /**
     * Lấy ip
     *        
     */
    static function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

   

    public static function getAbsVTImageByDate($id, $date, $imageName, $type) {
        $createDate = strtotime($date);
        $dateFolder = date('Y', $createDate) . date('m', $createDate);
        return Yii::$app->params['upload_url'] . '/' . $type . '/' . $dateFolder . "/" . $id . "/" . $imageName;
    }
    
    static function cleanQuery($string)
    {
        if(empty($string)) return $string;
        $string = trim($string);

        $badWords = array(
            "/Select(.*)From/i"
            , "/Union(.*)Select/i"
            , "/Update(.*)Set/i"
            , "/Delete(.*)From/i"
            , "/Drop(.*)Table/i"
            , "/Insert(.*)Into/i"
            , "/http/i"
            , "/--/i"
        );

        $string = preg_replace($badWords, "", $string);

        return $string;
    }
    
    static function dateTimeFormat($dateTime){
        $dt=new DateTime($dateTime);
        return date_format($dt , 'd/m/Y H:i');
    }
    
    static function getWeekDay($wday){
            switch($wday){
                case 0:
                    $value = array("id"=>8,"label"=>"Chủ nhật","alias"=>"chu-nhat","alias_int"=>"chu-nhat", "label_int" => "Chủ nhật");
                    break;
                case 1:
                    $value = array("id"=>2,"label"=>"Thứ hai","alias"=>"thu-hai","alias_int"=>"thu-2", "label_int" => "Thứ 2");
                    break;
                case 2:
                    $value = array("id"=>3,"label"=>"Thứ ba","alias"=>"thu-ba","alias_int"=>"thu-3", "label_int" => "Thứ 3");
                    break;
                case 3:
                    $value = array("id"=>4,"label"=>"Thứ tư","alias"=>"thu-tu","alias_int"=>"thu-4", "label_int" => "Thứ 4");
                    break;
                case 4:
                    $value = array("id"=>5,"label"=>"Thứ năm","alias"=>"thu-nam","alias_int"=>"thu-5", "label_int" => "Thứ 5");
                    break;
                case 5:
                    $value = array("id"=>6,"label"=>"Thứ sáu","alias"=>"thu-sau","alias_int"=>"thu-6", "label_int" => "Thứ 6");
                    break;
                case 6:
                    $value = array("id"=>7,"label"=>"Thứ bảy","alias"=>"thu-bay","alias_int"=>"thu-7", "label_int" => "Thứ 7");
                    break;
                default:
                    $value = array("id"=>0,"label"=>"");
                    break;
            }
            return $value;
        }
        
        static function getLotoMB($rows){  
            $loto = array();
            for($i=0;$i<4;$i++){
                $loto[] = isset($rows["giai_bay_".($i+1)]) ? substr($rows["giai_bay_".($i+1)],-2,2):"";
            }        
            for($i=0;$i<3;$i++){
                $loto[] = isset($rows["giai_sau_".($i+1)]) ? substr($rows["giai_sau_".($i+1)],-2,2):"";
            }
            for($i=0;$i<6;$i++){
                $loto[] = isset($rows["giai_nam_".($i+1)]) ? substr($rows["giai_nam_".($i+1)],-2,2):"";
            }
            for($i=0;$i<4;$i++){
                $loto[] = isset($rows["giai_tu_".($i+1)]) ? substr($rows["giai_tu_".($i+1)],-2,2):"";
            }
            for($i=0;$i<6;$i++){
                $loto[] = isset($rows["giai_ba_".($i+1)]) ? substr($rows["giai_ba_".($i+1)],-2,2):"";
            }
            for($i=0;$i<2;$i++){
                $loto[] = isset($rows["giai_nhi_".($i+1)]) ? substr($rows["giai_nhi_".($i+1)],-2,2):"";
            }
            $loto[] = isset($rows["giai_nhat"]) ? substr($rows["giai_nhat"],-2,2):"";
            $loto[] = isset($rows["giai_dacbiet"]) ? substr($rows["giai_dacbiet"],-2,2):"";
            sort($loto);
            return $loto;
        }

        static function getDauduoiMB($rows){
            $loto = Common::getLotoMB($rows);
            $dauduoi = array();
            for($i=0;$i<=9;$i++){
                $boso = "";
                for($j=0;$j<count($loto);$j++){
                    if(substr($loto[$j],0,1)==$i){
                        $boso .= substr($loto[$j],1).',';
                    }
                }
                $dauduoi[$i] = trim($boso,",");
            }
            return $dauduoi;
        }
        
        static function getLotoMT($rows){
            $loto = array();
            $loto[] = isset($rows["giai_tam"]) ? substr($rows["giai_tam"],-2,2):""; 
            $loto[] = isset($rows["giai_bay"]) ? substr($rows["giai_bay"],-2,2):"";
            for($i=0;$i<3;$i++){
                $loto[] = isset($rows["giai_sau_".($i+1)]) ? substr($rows["giai_sau_".($i+1)],-2,2):"";
            }
            $loto[]    = isset($rows["giai_nam"])      ? substr($rows["giai_nam"],-2,2):"";
            for($i=0;$i<7;$i++){
                $loto[] = isset($rows["giai_tu_".($i+1)]) ? substr($rows["giai_tu_".($i+1)],-2,2):"";
            }
            for($i=0;$i<2;$i++){
                $loto[] = isset($rows["giai_ba_".($i+1)]) ? substr($rows["giai_ba_".($i+1)],-2,2):"";
            }
            $loto[] = isset($rows["giai_nhi"]) ? substr($rows["giai_nhi"],-2,2):"";
            $loto[] = isset($rows["giai_nhat"]) ? substr($rows["giai_nhat"],-2,2):"";
            $loto[] = isset($rows["giai_dacbiet"]) ? substr($rows["giai_dacbiet"],-2,2):"";
            sort($loto);
            return $loto; 
        }
        
        static function getLotoMN($rows){
            $loto = array();
            $loto[] = isset($rows["giai_tam"]) ? substr($rows["giai_tam"],-2,2):""; 
            $loto[] = isset($rows["giai_bay"]) ? substr($rows["giai_bay"],-2,2):"";
            for($i=0;$i<3;$i++){
                $loto[] = isset($rows["giai_sau_".($i+1)]) ? substr($rows["giai_sau_".($i+1)],-2,2):"";
            }
            $loto[]    = isset($rows["giai_nam"])      ? substr($rows["giai_nam"],-2,2):"";
            for($i=0;$i<7;$i++){
                $loto[] = isset($rows["giai_tu_".($i+1)]) ? substr($rows["giai_tu_".($i+1)],-2,2):"";
            }
            for($i=0;$i<2;$i++){
                $loto[] = isset($rows["giai_ba_".($i+1)]) ? substr($rows["giai_ba_".($i+1)],-2,2):"";
            }
            $loto[] = isset($rows["giai_nhi"]) ? substr($rows["giai_nhi"],-2,2):"";
            $loto[] = isset($rows["giai_nhat"]) ? substr($rows["giai_nhat"],-2,2):"";
            $loto[] = isset($rows["giai_dacbiet"]) ? substr($rows["giai_dacbiet"],-2,2):"";
            sort($loto);
            return $loto; 
        }
        static function getDauduoiMN($rows){
            $loto = Common::getLotoMN($rows);
            $dauduoi = array();
            for($i=0;$i<=9;$i++){
                $boso = "";
                for($j=0;$j<count($loto);$j++){
                    if(substr($loto[$j],0,1)==$i){
                        $boso .= substr($loto[$j],1).',';
                    }
                }
                $dauduoi[$i] = trim($boso,",");
            }
            return $dauduoi;
        }

        public static function dump($value) {
            var_dump($value);
            die();
        }
        
        public static function getVitriBoso($giai,$boso,$x,$y,$region){
            if($region ==1){
                $vitri = LoadConfig::$positionResultMB[$giai];        
            } else if($region==2){
                $vitri = LoadConfig::$positionResultMT[$giai];
            } else if($region ==3){
                $vitri = LoadConfig::$positionResultMN[$giai];
            }
            $strboso = "";
            $vitri_do_x=-1;
            $vitri_do_y=-1;
            if($x>=$vitri[0]&&$x<=$vitri[1]){                      
                $vitri_do_x =$x - $vitri[0];  
            }  
            if($y>=$vitri[0]&&$y<=$vitri[1]){                      
                $vitri_do_y =$y - $vitri[0];     
            }
            for($i=0;$i<strlen($boso);$i++)
            {
                if($vitri_do_x==$i||$vitri_do_y==$i){
                    $strboso .="<font color='red'>".substr($boso,$i,1)."</font>";  
                } else{
                    $strboso .=substr($boso,$i,1);  
                } 
            }   

            return $strboso;              
        }
        
        public static function getWeekDayFromDate($date, $label_int = true) {
             $day = getdate(strtotime($date)); 
             $wday = Common::getWeekDay($day["wday"]);      
             if ($label_int) {
                 return $wday['label_int'];
             }
             return $wday['label'];
        }
        
        public static function getWeekDayFromTime($time, $label_int = true) {
             $day = getdate($time); 
             $wday = Common::getWeekDay($day["wday"]);      
             if ($label_int) {
                 return $wday['label_int'];
             }
             return $wday['label'];
        }
        
        public static function getWeekDayAliasFromDate($date, $label_int = true) {
             $day = getdate(strtotime($date)); 
             $wday = Common::getWeekDay($day["wday"]);      
             if ($label_int) {
                 return $wday['alias_int'];
             }
             return $wday['alias'];
        }
        
        public static function getWeekDayAliasFromTime($time, $label_int = true) {
             $day = getdate($time); 
             $wday = Common::getWeekDay($day["wday"]);      
             if ($label_int) {
                 return $wday['alias_int'];
             }
             return $wday['alias'];
        }
        
        public static function getLabelResultMB($rows,$loto){  
            $result = array();        
            if($loto==substr($rows["giai_dacbiet"],-2,2)){
                $result[] = "GDB";
            }
            if($loto==substr($rows["giai_nhat"],-2,2)){
                $result[] = "G1";
            } 
            if($loto==substr($rows["giai_nhi_1"],-2,2) || $loto==substr($rows["giai_nhi_2"],-2,2)){
                $result[] = "G2";
            }
            if($loto==substr($rows["giai_ba_1"],-2,2) || $loto==substr($rows["giai_ba_2"],-2,2) || $loto==substr($rows["giai_ba_3"],-2,2) || $loto==substr($rows["giai_ba_4"],-2,2) || $loto==substr($rows["giai_ba_5"],-2,2) || $loto==substr($rows["giai_ba_6"],-2,2)){
                $result[] = "G3";
            }
            if($loto==substr($rows["giai_tu_1"],-2,2) || $loto==substr($rows["giai_tu_2"],-2,2) || $loto==substr($rows["giai_tu_3"],-2,2) || $loto==substr($rows["giai_tu_4"],-2,2)){
                $result[] = "G4";
            } 
            if($loto==substr($rows["giai_nam_1"],-2,2) || $loto==substr($rows["giai_nam_2"],-2,2) || $loto==substr($rows["giai_nam_3"],-2,2) || $loto==substr($rows["giai_nam_4"],-2,2) || $loto==substr($rows["giai_nam_5"],-2,2) || $loto==substr($rows["giai_nam_6"],-2,2)){
                $result[] = "G5";
            }
            if($loto==substr($rows["giai_sau_1"],-2,2) || $loto==substr($rows["giai_sau_2"],-2,2) || $loto==substr($rows["giai_sau_3"],-2,2)){
                $result[] = "G6";
            } 
            if($loto==substr($rows["giai_bay_1"],-2,2) || $loto==substr($rows["giai_bay_2"],-2,2) || $loto==substr($rows["giai_bay_3"],-2,2) || $loto==substr($rows["giai_bay_4"],-2,2)){
                $result[] = "G7";
            }
            return $result;
        }

        public static function getLabelResultMN($rows,$loto){  
            $result = array();        
            if($loto==substr($rows["giai_dacbiet"],-2,2)){
                $result[] = "GDB";
            }
            if($loto==substr($rows["giai_nhat"],-2,2)){
                $result[] = "G1";
            } 
            if($loto==substr($rows["giai_nhi"],-2,2)){
                $result[] = "G2";
            }
            if($loto==substr($rows["giai_ba_1"],-2,2) || $loto==substr($rows["giai_ba_2"],-2,2)){
                $result[] = "G3";
            }
            if($loto==substr($rows["giai_tu_1"],-2,2) || $loto==substr($rows["giai_tu_2"],-2,2) || $loto==substr($rows["giai_tu_3"],-2,2) || $loto==substr($rows["giai_tu_4"],-2,2) || $loto==substr($rows["giai_tu_5"],-2,2) || $loto==substr($rows["giai_tu_6"],-2,2) || $loto==substr($rows["giai_tu_7"],-2,2)){
                $result[] = "G4";
            } 
            if($loto==substr($rows["giai_nam"],-2,2)){
                $result[] = "G5";
            }
            if($loto==substr($rows["giai_sau_1"],-2,2) || $loto==substr($rows["giai_sau_2"],-2,2) || $loto==substr($rows["giai_sau_3"],-2,2)){
                $result[] = "G6";
            } 
            if($loto==substr($rows["giai_bay"],-2,2)){
                $result[] = "G7";
            }
            if($loto==substr($rows["giai_tam"],-2,2)){
                $result[] = "G8";
            }
            return $result;
        }

        public static function getLabelResultMT($rows,$loto){  
            $result = array();        
            if($loto==substr($rows["giai_dacbiet"],-2,2)){
                $result[] = "GDB";
            }
            if($loto==substr($rows["giai_nhat"],-2,2)){
                $result[] = "G1";
            } 
            if($loto==substr($rows["giai_nhi"],-2,2)){
                $result[] = "G2";
            }
            if($loto==substr($rows["giai_ba_1"],-2,2) || $loto==substr($rows["giai_ba_2"],-2,2)){
                $result[] = "G3";
            }
            if($loto==substr($rows["giai_tu_1"],-2,2) || $loto==substr($rows["giai_tu_2"],-2,2) || $loto==substr($rows["giai_tu_3"],-2,2) || $loto==substr($rows["giai_tu_4"],-2,2) || $loto==substr($rows["giai_tu_5"],-2,2) || $loto==substr($rows["giai_tu_6"],-2,2) || $loto==substr($rows["giai_tu_7"],-2,2)){
                $result[] = "G4";
            } 
            if($loto==substr($rows["giai_nam"],-2,2)){
                $result[] = "G5";
            }
            if($loto==substr($rows["giai_sau_1"],-2,2) || $loto==substr($rows["giai_sau_2"],-2,2) || $loto==substr($rows["giai_sau_3"],-2,2)){
                $result[] = "G6";
            } 
            if($loto==substr($rows["giai_bay"],-2,2)){
                $result[] = "G7";
            }
            if($loto==substr($rows["giai_tam"],-2,2)){
                $result[] = "G8";
            }
            return $result;
        }
        
        static public function getRandomResultMB(){
            $result = array();
            for($i=1;$i<=4;$i++){
                $result[$i] = rand(0,9).rand(0,9);
            }
            for($i=5;$i<=7;$i++){
                $result[$i] = rand(0,9).rand(10,99);
            }
            for($i=8;$i<=17;$i++){
                $result[$i] = rand(0,9).rand(100,999);
            }
            for($i=18;$i<=27;$i++){
                $result[$i] = rand(0,9).rand(1000,9999);
            }
            return $result;
        }

        static public function getRandomResultMN(){
            $result = array();
            $result[1] = rand(0,9).rand(0,9);
            $result[2] = rand(0,9).rand(10,99);
            for($i=3;$i<=6;$i++){
                $result[$i] = rand(0,9).rand(100,999);
            }
            for($i=7;$i<=17;$i++){
                $result[$i] = rand(0,9).rand(1000,9999);
            }
            $result[18] = rand(0,9).rand(10000,99999);
            return $result;
        }
        
        static public function getRandomLotoTinh($result){
            $loto = array();
            for ($i =1; $i <=18;$i++) {
                $loto[] = isset($rows[$i]) ? substr($rows[$i],-2,2):""; 
            }

            sort($loto);
            return $loto; 
        }
        
        static public function getRandomLotoMB($rows){
            $loto = array();
            for ($i =1; $i <=27;$i++) {
                $loto[] = isset($rows[$i]) ? substr($rows[$i],-2,2):""; 
            }
            sort($loto);
            return $loto; 
        }
        
        static public function getRandomLotoMien($rows){
            $loto = array();
            for ($i =1; $i <=18;$i++) {
                $loto[] = isset($rows[$i]) ? substr($rows[$i],-2,2):""; 
            }
            sort($loto);
            return $loto; 
        }
        
        static public function getRandomResultMien($count){
            $result = array();
            $k = 1;
            for($j = 0;$j< $count;$j++) {
            $result[$k] = rand(0,9).rand(0,9);
            $k++;
            
            }
            for($j = 0;$j< $count;$j++) {
                $result[$k] = rand(0,9).rand(10,99);
                $k++;
            }
             for($j = 0;$j< $count;$j++) {
                for($i=3;$i<=6;$i++){
                    $result[$k] = rand(0,9).rand(100,999);
                    $k++;
                }
             }
             for($j = 0;$j< $count;$j++) {
            for($i=7;$i<=17;$i++){
                $result[$k] = rand(0,9).rand(1000,9999);
                $k++;
            }
             }
              for($j = 0;$j< $count;$j++) {
                $result[$k] = rand(0,9).rand(10000,99999);
                $k++;
              }
            return $result;
        }

        static public function getRandomResultMT(){
            $result = array();
            $result[1] = rand(0,9).rand(0,9);
            $result[2] = rand(0,9).rand(10,99);
            for($i=3;$i<=6;$i++){
                $result[$i] = rand(0,9).rand(100,999);
            }
            for($i=7;$i<=17;$i++){
                $result[$i] = rand(0,9).rand(1000,9999);
            }
            $result[18] = rand(0,9).rand(10000,99999);
            return $result;
        }
}