<?php
namespace common\utils;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dump
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
class Dump {
    //put your code here
    public static function errors($errors, $die = true)
    {
        ob_start();
        echo '<h2>Tóm tắt lỗi</h2>';
        if (is_array($errors)) {
            echo '<ul>';
            foreach ($errors as $item) {
                foreach ($item as $message) {
                    if (is_string($message)) {
                        echo "<li>$message</li>";
                    }
                }
            }
            echo '</ul>';
            echo '<p>===================</p>';
        }
        var_dump($errors);
        echo '<pre>' . ob_get_clean() . '</pre>';
        if ($die) {
            die();
        }
    }
    public static function variable($variable, $die = true)
    {
        ob_start();
        var_dump($variable);
        echo '<pre>' . ob_get_clean() . '</pre>';
        if ($die) {
            die();
        }
    }
}
