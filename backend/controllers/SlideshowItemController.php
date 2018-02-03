<?php

namespace backend\controllers;

use Yii;
use backend\models\SlideshowItem;
use backend\models\SlideshowItemSearch;
use backend\controllers\BaseController;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SlideshowItemController implements the CRUD actions for SlideshowItem model.
 */
class SlideshowItemController extends BaseController
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
     * Lists all SlideshowItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SlideshowItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Url::remember();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SlideshowItem model.
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
     * Creates a new SlideshowItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $username = Yii::$app->user->identity->username;
        $model = new SlideshowItem();
        
        if (Yii::$app->request->isPost && $model = SlideshowItem::create(Yii::$app->request->post())) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'username' => $username,
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SlideshowItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $username = Yii::$app->user->identity->username;
        if ($model = $this->findModel($id)) {
            if (Yii::$app->request->isPost && $model->update2(Yii::$app->request->post())) {
                return $this->goBack(Url::previous());
            } else {
                return $this->render('update', [
                    'username' => $username,
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Deletes an existing SlideshowItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($model = $this->findModel($id)) {
            $model->delete();
            return $this->goBack(Url::previous());
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Finds the SlideshowItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SlideshowItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SlideshowItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
