<?php

namespace backend\controllers;

use Yii;
use backend\models\TeleMessage;
use backend\models\TeleMessageSearch;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeleMessageController implements the CRUD actions for TeleMessage model.
 */
class TeleMessageController extends Controller
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
     * Lists all TeleMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeleMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Url::remember();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeleMessage model.
     * @param integer $chat_id
     * @param string $id
     * @return mixed
     */
    public function actionView($chat_id, $id)
    {
        $model = $this->findModel($chat_id, $id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new TeleMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $username = Yii::$app->user->identity->username;
        $model = new TeleMessage();
        
        if (Yii::$app->request->isPost && $model = TeleMessage::create(Yii::$app->request->post())) {
            return $this->redirect(['update', 'chat_id' => $model->chat_id, 'id' => $model->id]);
        }
        
        return $this->render('create', [
            'username' => $username,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TeleMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $chat_id
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($chat_id, $id)
    {
        $username = Yii::$app->user->identity->username;
        
        $model = $this->findModel($chat_id, $id);
        
        if (Yii::$app->request->isPost && $model->update2(Yii::$app->request->post())) {
            return $this->goBack(Url::previous());
        }
        
        return $this->render('update', [
            'username' => $username,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TeleMessage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $chat_id
     * @param string $id
     * @return mixed
     */
    public function actionDelete($chat_id, $id)
    {
        $model = $this->findModel($chat_id, $id);
        $model->delete();
        
        return $this->goBack(Url::previous());
    }

    /**
     * Finds the TeleMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $chat_id
     * @param string $id
     * @return TeleMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($chat_id, $id)
    {
        if (($model = TeleMessage::findOne(['chat_id' => $chat_id, 'id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
