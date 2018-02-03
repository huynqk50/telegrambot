<?php
namespace common\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleCategory
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
class ArticleCategory extends MyActiveRecord {
    const TYPE_FOOTBALL_TEAM = 1;
    const TYPE_FOOTBALL_COUNTRY = 2;
    const TYPE_FOOTBALL_TOURNAMENT = 3;
    
    public static $types = [
        self::TYPE_FOOTBALL_TEAM => 'Đội bóng đá',
        self::TYPE_FOOTBALL_COUNTRY => 'Bóng đá các quốc gia',
        self::TYPE_FOOTBALL_TOURNAMENT => 'Giải đấu bóng đá'
    ];
}
