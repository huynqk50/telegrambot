<?php
namespace common\models;

/**
 * Description of PurchaseOrder
 *
 * @author Tran Van Quyet <quyettvq at gmail.com>
 */
class PurchaseOrder extends MyActiveRecord {
    const STATUS_NEW = 1;
    const STATUS_PENDING = 2;
    const STATUS_SUCCESS = 3;
    const STATUS_CANCELED = 4;
    const STATUS_REJECT = 5;
    
    public static function statuses() {
        return [
            self::STATUS_NEW => 'Mới',
            self::STATUS_PENDING => 'Đang chờ xử lý',
            self::STATUS_SUCCESS => 'Thành công',
            self::STATUS_CANCELED => 'Bị khách hủy',
            self::STATUS_REJECT => 'Từ chối thực hiện',
        ];
    }

    public static function generateCode($n = 8, $prefix = '', $suffix = '')
    {
        $main = '';
        
        for ($i = 0; $i < $n; $i++) {
            $main .= rand(0, 9);
        }
        
        $result = $prefix . $main . $suffix;
        
        return $result;
    }
}
