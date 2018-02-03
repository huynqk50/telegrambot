<?php

namespace common\models;

/**
 * Description of Custommer
 *
 * @author Tran Van Quyet <quyettvq at gmail.com>
 */
class Customer extends User {
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHER = 3;
    
    public function genders() {
        return [
            self::GENDER_MALE => 'Nam',
            self::GENDER_FEMALE => 'Nữ',
            self::GENDER_OTHER => 'Khác',
        ];
    }
    
    public function getGenderLabel()
    {
        $genders = $this->genders();
        return isset($genders[$this->gender]) ? $genders[$this->gender] : $this->gender;
    }
    
}