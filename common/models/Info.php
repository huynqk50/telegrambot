<?php

namespace common\models;

class Info extends MyActiveRecord {
    //put your code here
    
    const TYPE_FAQ = 1;
    const TYPE_PROFILE = 2;
    const TYPE_CONTACT = 3;
    const TYPE_COOPERATION = 4;
    const TYPE_PARTNER_POLICY = 5;
    const TYPE_RECRUITMENT = 6;
    const TYPE_SECURITY_POLICY = 7;
    const TYPE_TERM_OF_USE = 8;
    const TYPE_VIP_CARD = 9;
    const TYPE_PAYMENT_GUIDE = 10;
    const TYPE_PAYMENT_REGULATION = 11;
    const TYPE_SERVICES = 12;
    const TYPE_PARTNER = 13;
    const TYPE_BOTTOM_INFO = 14;
    
    public static $types = [
        self::TYPE_FAQ => 'Hỏi đáp',
        self::TYPE_PROFILE => 'Giới thiệu',
        self::TYPE_CONTACT => 'Liên hệ',
        self::TYPE_COOPERATION => 'Hợp tác bán hàng',
        self::TYPE_PARTNER_POLICY => 'Chính sách đại lý',
        self::TYPE_RECRUITMENT => 'Tuyển dụng',
        self::TYPE_SECURITY_POLICY => 'Chính sách bảo mật',
        self::TYPE_TERM_OF_USE => 'Điều khoản và điều kiện',
        self::TYPE_VIP_CARD => 'Quyền lợi thẻ VIP',
        self::TYPE_PAYMENT_GUIDE => 'Hướng dẫn thanh toán',
        self::TYPE_PAYMENT_REGULATION => 'Quy định thanh toán',
        self::TYPE_SERVICES => 'Dịch vụ',
        self::TYPE_PARTNER => 'Đối tác',
        self::TYPE_BOTTOM_INFO => 'Chân trang',
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info';
    }

    /**
     * @inheritdoc
     */
    public function rules() 
    { 
       return [ 
           [['name', 'type', 'slug', 'content', 'created_at', 'created_by'], 'required'], 
           [['type', 'is_active'], 'integer'], 
           [['long_description', 'content'], 'string'], 
           [['created_at', 'updated_at'], 'safe'], 
           [['name', 'slug', 'page_title', 'h1', 'meta_title', 'meta_description', 'meta_keywords', 'image', 'image_path', 'created_by', 'updated_by'], 'string', 'max' => 255], 
           [['description'], 'string', 'max' => 511], 
           [['old_slugs'], 'string', 'max' => 2000], 
           [['slug', 'is_active'], 'unique', 'targetAttribute' => ['slug', 'is_active'], 'message' => 'The combination of Slug and Is Active has already been taken.'] 
       ]; 
    }
}
