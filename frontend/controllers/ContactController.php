<?php

namespace frontend\controllers;

use common\utils\Json;
use frontend\models\Contact;
use frontend\models\ContactForm;
use Yii;
use yii\web\BadRequestHttpException;

class ContactController extends BaseController
{

    public function actionIndex()
    {
        $model = new ContactForm;
//        $model = Info::find()->where(['type' => Info::TYPE_CONTACT])->one();
//        var_dump($members);die();
        return $this->render('index', ['model' => $model]);
    }

    public function actionAjaxCreate()
    {
        $response = 0;
        
        if (Yii::$app->request->isPost) {
            $model = new Contact();
            $model->scenario = 'full';
            $data = Json::decode(Yii::$app->request->post('Contact'), true);
            if ($model->load(['Contact' => $data]) && $model->save()) {
                $response = 1;
            } else {
                $response = json_encode($model->errors);
            }
        }
        
        return $response;
    }
    
    public function actionCreateWithEmail()
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException;
        }
        $model = new Contact;
        $model->scenario = 'only-email';
        $model->email = Yii::$app->request->post('email', '');
        $model->message = '';
        
        if ($model->save()) {
            return 1;
        }
        
        return 0;
    }
    
}
