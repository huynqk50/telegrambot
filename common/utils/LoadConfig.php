<?php
namespace common\utils;
    class LoadConfig{
        static public $string_wday = array(
            2=>"Thứ hai"
            ,3=>"Thứ ba"
            ,4=>"Thứ tư"
            ,5=>"Thứ năm"
            ,6=>"Thứ sáu"
            ,7=>"Thứ bảy"
            ,8=>"Chủ nhật"
        );
        
        static public $string_wday_int = array(
            2=>"Thứ 2"
            ,3=>"Thứ 3"
            ,4=>"Thứ 4"
            ,5=>"Thứ 5"
            ,6=>"Thứ 6"
            ,7=>"Thứ 7"
            ,8=>"Chủ nhật"
        );

        static public $string_token ='api#ve%so';
        
        static public $status = array(
            1=>"Hiển thị",
            0=>"Không hiển thị"
        );

        static public $region = array(
            "mb"=>array("hour_live"=>18,"id"=>1,"name"=>"Miền Bắc","action"=>"mienbac")
            ,"mt"=>array("hour_live"=>17,"id"=>2,"name"=>"Miền Trung","action"=>"mientrung")
            ,"mn"=>array("hour_live"=>16,"id"=>3,"name"=>"Miền Nam","action"=>"miennam")
        );    
       

        static public $wday = array(
            "thu-hai"=>2,
            "thu-ba"=>3,
            "thu-tu"=>4,
            "thu-nam"=>5,
            "thu-sau"=>6,
            "thu-bay"=>7,
            "chu-nhat"=>8,
        );
        
        static public $wday_int = array(
            "thu-2"=>2,
            "thu-3"=>3,
            "thu-4"=>4,
            "thu-5"=>5,
            "thu-6"=>6,
            "thu-7"=>7,
            "chu-nhat"=>8,
        );
        
        static public $label_mb = array(
            2=>"Hà Nội",
            3=>"Quảng Ninh",
            4=>"Bắc Ninh",
            5=>"Hà Nội",
            6=>"Hải Phòng",
            7=>"Nam Định",
            8=>"Thái Bình",
        );

        static public $weekday_back = array(
            2=>1,3=>2,4=>3,5=>4,6=>5,7=>6,8=>0
        );
        static public $weekday = array(
            0=>8,1=>2,2=>3,3=>4,4=>5,5=>6,6=>7
        );

        static public $weekday_mysql = array(
            2=>0,3=>1,4=>2,5=>3,6=>4,7=>5,8=>6
        );

        static public $result_mb = array(
            "giai_bay_1" => "","giai_bay_2" => "","giai_bay_3" => "","giai_bay_4" => "",
            "giai_sau_1" => "","giai_sau_2" => "","giai_sau_3" => "",
            "giai_nam_1" => "","giai_nam_2" => "","giai_nam_3" => "","giai_nam_4" => "","giai_nam_5" => "","giai_nam_6" => "",
            "giai_tu_1" => "","giai_tu_2" => "","giai_tu_3" => "","giai_tu_4" => "",
            "giai_ba_1" => "","giai_ba_2" => "","giai_ba_3" => "","giai_ba_4" => "","giai_ba_5" => "","giai_ba_6" => "",
            "giai_nhi_1" => "","giai_nhi_2" => "",
            "giai_nhat" => "","giai_dacbiet" => ""
        );

        static public $result_mn = array(
            "giai_tam" => "","giai_bay" => "","giai_sau_1" => "","giai_sau_2" => "","giai_sau_3" => "","giai_nam" => "",
            "giai_tu_1" => "","giai_tu_2" => "","giai_tu_3" => "","giai_tu_4" => "","giai_tu_5" => "",
            "giai_tu_6" => "","giai_tu_7" => "","giai_ba_1" => "","giai_ba_2" => "","giai_nhi" => "","giai_nhat" => "",
            "giai_dacbiet" => ""
        );

        static public $result_mt = array(
            "giai_tam" => "","giai_bay" => "","giai_sau_1" => "","giai_sau_2" => "","giai_sau_3" => "","giai_nam" => "",
            "giai_tu_1" => "","giai_tu_2" => "","giai_tu_3" => "","giai_tu_4" => "","giai_tu_5" => "",
            "giai_tu_6" => "","giai_tu_7" => "","giai_ba_1" => "","giai_ba_2" => "","giai_nhi" => "","giai_nhat" => "",
            "giai_dacbiet" => ""
        );


    }

