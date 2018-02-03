<?php

namespace frontend\controllers;

use frontend\models\Store;
use yii\helpers\Url;

class StoreController extends BaseController
{
    public function actionIndex()
    {
        $this->link_canonical = Url::current([], true);
        $this->breadcrumbs[] = ['label' => 'Cửa hàng', 'url' => $this->link_canonical];
        
        $stores = Store::find()->all();
        
        return $this->render('index', [
            'stores' => $stores
        ]);
    }

}
