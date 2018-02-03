<?php
/*
namespace backend\controllers;

class TestController extends \yii\web\Controller {
    //put your code here
    public function actionUpdateArticles()
    {
        $k = 0;
        foreach (\backend\models\Article::find()->all() as $item) {
            if (strpos($item->content, 'HDC1') !== false) {
                $k++;
//                echo $item->content;
                echo '<br><br><br><br><br>';
                $item->content = str_replace('HDC1', 'GO', $item->content);
                if ($item->save()) {
                    echo $item->content;
                } else {
                    var_dump($item->errors);
                }
            }
        }
        echo $k;
        return;
    }
}
