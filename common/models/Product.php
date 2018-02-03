<?php
namespace common\models;

class Product extends MyActiveRecord {
    public function price($column = 'price')
    {
        return Currency::vnd($this->$column);
    }
    
    const STATUS_HIGHTLIGHT = 1;
    const STATUS_FOR_YOU = 2;
    const STATUS_ONLY_HERE = 3;
    const STATUS_HOT_SALE = 4;
    
    public static $statuses = [
        self::STATUS_HIGHTLIGHT => 'Điểm nhấn trong tuần',
        self::STATUS_FOR_YOU => 'Dành riêng cho bạn',
        self::STATUS_ONLY_HERE => 'Chỉ có tại Veneto',
        self::STATUS_HOT_SALE => 'Sản phẩm HOT',
    ];
    
//    const IMAGE_TINY = '[105,105]';
//    const IMAGE_SMALL = '[270,270]';
//    const IMAGE_MEDIUM = '[370,370]';
//    const IMAGE_LARGE = '[420,420]';
//    const IMAGE_HUGE = '[550,550]';
//    const IMAGE_VERY_HUGE = '[600,600]';
//    
//    const BANNER_TINY = '[340,340]';
//    const BANNER_SMALL = '[365,365]';
//    const BANNER_MEDIUM = '[400,400]';
//    const BANNER_LARGE = '[540,540]';
//    const BANNER_HUGE = '[740,740]';
//    
//    public static $image_resizes = [
//        self::IMAGE_TINY,
//        self::IMAGE_SMALL,
//        self::IMAGE_MEDIUM,
//        self::IMAGE_LARGE,
//        self::IMAGE_HUGE,
//    ];
//    
//    public static $banner_resizes = [
//        self::BANNER_TINY,
//        self::BANNER_SMALL,
//        self::BANNER_MEDIUM,
//        self::BANNER_LARGE,
//        self::BANNER_HUGE,
//    ];

    public function updateQuantityAndRevenue()
    {
        $this->total_quantity = 0;
        $this->sold_quantity = 0;
        $this->order_quantity = 0;
        $this->available_quantity = 0;
        $this->total_revenue = 0;

        foreach ($this->productCustomizations as $customization) {
            $this->total_quantity += $customization->total_quantity;
            $this->sold_quantity += $customization->sold_quantity;
            $this->order_quantity += $customization->order_quantity;
            $this->available_quantity += $customization->available_quantity;
            $this->total_revenue += $customization->total_revenue;
        }

        $this->save();
    }
}
