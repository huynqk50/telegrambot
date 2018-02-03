<?php

namespace backend\controllers;

class TestController extends \yii\web\Controller {
    //put your code here
    public function actionIndex()
    {
        return $this->render('index');
    }
}
