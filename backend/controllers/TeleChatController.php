<?php

namespace backend\controllers;

use Yii;
use backend\models\TeleChat;
use backend\models\TeleChatSearch;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeleChatController implements the CRUD actions for TeleChat model.
 */
class TeleChatController extends Controller
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
     * Lists all TeleChat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeleChatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Url::remember();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeleChat model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new TeleChat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $username = Yii::$app->user->identity->username;
        $model = new TeleChat();
        
        if (Yii::$app->request->isPost && $model = TeleChat::create(Yii::$app->request->post())) {
            return $this->redirect(['update', 'id' => $model->id]);
        }
        
        return $this->render('create', [
            'username' => $username,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TeleChat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $username = Yii::$app->user->identity->username;
        
        $model = $this->findModel($id);
        
        if (Yii::$app->request->isPost && $model->update2(Yii::$app->request->post())) {
            return $this->goBack(Url::previous());
        }
        
        return $this->render('update', [
            'username' => $username,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TeleChat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        
        return $this->goBack(Url::previous());
    }

    /**
     * Finds the TeleChat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TeleChat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TeleChat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
