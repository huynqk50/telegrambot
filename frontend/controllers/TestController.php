<?php

namespace frontend\controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestController
 *
 * @author Tran Van Quyet <quyettvq at gmail.com>
 */
class TestController extends BaseController {
    public function actionIndex()
    {
        $user = new \frontend\models\Customer;
        $password = 'abc';
        
        $user->setPassword($password);
        var_dump($user->password_hash);
        return $user->validatePassword($password);
    }
}
