<?php

namespace frontend\controllers;

use frontend\models\Customer;
use frontend\models\Redirect;
use frontend\models\UrlParam;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends BaseController
{
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $username = Yii::$app->request->get(UrlParam::USERNAME);
        if (!($model = Customer::findOne(['username' => $username]))) {
            throw new NotFoundHttpException();
        }
        $this->link_canonical = $model->getLink();
        
        $this->page_title = $this->meta_title = $this->h1 = "Thông tin khách hàng $model->username";
        $this->meta_description = "Thông tin khách hàng $model->username";
        $this->meta_keywords = "$model->username";
        
        $this->breadcrumbs[] = ['label' => $model->username, 'url' => $model->getLink()];
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if ($model = $this->findModel($id)) {
            return $this->render('view', [
                'model' => $model,
            ]);
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new Customer();
        $model->scenario = Customer::SCENARIO_CREATE;

        if (Yii::$app->request->isPost && $model = Customer::create(Yii::$app->request->post())) {
            if (!$model->hasErrors()) {
                Yii::$app->mailer->compose(['html' => 'hiNewUser-html', 'text' => 'hiNewUser-text'], ['user' => $model])
                    ->setFrom([Yii::$app->params['noreplyEmail'] => Yii::$app->name])
                    ->setTo($model->email)
                    ->setSubject("Xin chào $model->username")
                    ->send();
                Yii::$app->session->setFlash('message', 'Đăng ký thành công! Vui lòng kiểm tra email để kích hoạt tài khoản.');
                $model = new Customer();
                $model->scenario = Customer::SCENARIO_CREATE;
            }
        }
        
        if (!$this->seo_exist) {
            $this->page_title = $this->meta_title = $this->h1 = 'Đăng ký làm thành viên của Veneto';
            $this->meta_description = 'Đăng ký làm thành viên của Veneto để nhận những ưu đãi tốt nhất từ chúng tôi';
            $this->meta_keywords = 'Đăng ký, dang ky';
        }
        
        $this->breadcrumbs[] = ['label' => 'Đăng ký', 'url' => Url::current([], true)];
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $username = Yii::$app->user->identity->username;
        if (!($model = Customer::findOne(['username' => $username]))) {
            throw new NotFoundHttpException();
        }
        $this->link_canonical = $model->getUpdateLink();
        
        if (!Redirect::compareUrl($this->link_canonical)) {
            return $this->redirect($this->link_canonical);
        }
        
        $model->scenario = Customer::SCENARIO_UPDATE;
        if (Yii::$app->request->isPost && $model->update2(Yii::$app->request->post())) {
            Yii::$app->session->setFlash('success', 'Thay đổi thông tin tài khoản thành công.');
            
            return $this->redirect($model->getLink());
        } else {
            
            if (!$this->seo_exist) {
                $this->page_title = $this->meta_title = $this->h1 = 'Thay đổi thông tin cá nhân';
                $this->meta_description = 'Thay đổi thông tin cá nhân';
                $this->meta_keywords = 'Thay đổi thông tin cá nhân, thay doi thong tin ca nhan';
            }
            
            $this->breadcrumbs[] = ['label' => $model->username, 'url' => $model->getLink()];
            $this->breadcrumbs[] = ['label' => 'Thay đổi thông tin cá nhân', 'url' => Url::current([], true)];
            
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdatePassword()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $username = Yii::$app->user->identity->username;
        if (!($model = Customer::findOne(['username' => $username]))) {
            throw new NotFoundHttpException();
        }
        
        $this->link_canonical = $model->getUpdatePasswordLink();
        
        if (!Redirect::compareUrl($this->link_canonical)) {
            return $this->redirect($this->link_canonical);
        }
        
        $model->scenario = Customer::SCENARIO_UPDATE_PASSWORD;
        if (Yii::$app->request->isPost && $model->update2(Yii::$app->request->post())) {
            Yii::$app->session->setFlash('success', 'Thay đổi mật khẩu thành công.');
            
            return $this->redirect($model->getLink());
        } else {
            
            if (!$this->seo_exist) {
                $this->page_title = $this->meta_title = $this->h1 = 'Thay đổi mật khẩu';
                $this->meta_description = 'Thay đổi mật khẩu';
                $this->meta_keywords = 'Thay đổi mật khẩu, thay doi mat khau';
            }
            
            $this->breadcrumbs[] = ['label' => $model->username, 'url' => $model->getLink()];
            $this->breadcrumbs[] = ['label' => 'Thay đổi mật khẩu', 'url' => Url::current([], true)];
            
            return $this->render('updatePassword', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Không tồn tại trang này.');
        }
    }
}
