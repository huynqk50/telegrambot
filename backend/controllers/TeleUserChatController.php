<?php

namespace backend\controllers;

use Yii;
use backend\models\TeleUserChat;
use backend\models\TeleUserChatSearch;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeleUserChatController implements the CRUD actions for TeleUserChat model.
 */
class TeleUserChatController extends Controller
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
     * Lists all TeleUserChat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeleUserChatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Url::remember();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeleUserChat model.
     * @param integer $user_id
     * @param integer $chat_id
     * @return mixed
     */
    public function actionView($user_id, $chat_id)
    {
        $model = $this->findModel($user_id, $chat_id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new TeleUserChat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $username = Yii::$app->user->identity->username;
        $model = new TeleUserChat();
        
        if (Yii::$app->request->isPost && $model = TeleUserChat::create(Yii::$app->request->post())) {
            return $this->redirect(['update', 'user_id' => $model->user_id, 'chat_id' => $model->chat_id]);
        }
        
        return $this->render('create', [
            'username' => $username,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TeleUserChat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param integer $chat_id
     * @return mixed
     */
    public function actionUpdate($user_id, $chat_id)
    {
        $username = Yii::$app->user->identity->username;
        
        $model = $this->findModel($user_id, $chat_id);
        
        if (Yii::$app->request->isPost && $model->update2(Yii::$app->request->post())) {
            return $this->goBack(Url::previous());
        }
        
        return $this->render('update', [
            'username' => $username,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TeleUserChat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param integer $chat_id
     * @return mixed
     */
    public function actionDelete($user_id, $chat_id)
    {
        $model = $this->findModel($user_id, $chat_id);
        $model->delete();
        
        return $this->goBack(Url::previous());
    }

    /**
     * Finds the TeleUserChat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param integer $chat_id
     * @return TeleUserChat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $chat_id)
    {
        if (($model = TeleUserChat::findOne(['user_id' => $user_id, 'chat_id' => $chat_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
