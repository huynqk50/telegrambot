<?php

namespace backend\controllers;

use backend\models\ArticleRelated;
use Yii;
use backend\models\Article;
use backend\models\ArticleSearch;
use backend\controllers\BaseController;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends BaseController
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
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Url::remember();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
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
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $username = Yii::$app->user->identity->username;
        $model = new Article();
        
        if (Yii::$app->request->isPost && $model = Article::create(Yii::$app->request->post())) {

            is_array($model->related_ids) or $model->related_ids = [];
            foreach ($model->related_ids as $related_id) {
                ArticleRelated::create([
                    'ArticleRelated' => [
                        'article_id' => $model->id,
                        'related_id' => $related_id
                    ]
                ]);
            }

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'username' => $username,
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $username = Yii::$app->user->identity->username;
        if ($model = $this->findModel($id)) {

            $model->related_ids = ArrayHelper::getColumn(ArticleRelated::findAll(['article_id' => $model->id]), 'related_id', false);
            $oldRelatedIds = $model->related_ids;

            if (Yii::$app->request->isPost && $model->update2(Yii::$app->request->post())) {

                is_array($model->related_ids) or $model->related_ids = [];
                foreach ($model->related_ids as $related_id) {
                    if (!in_array($related_id, $oldRelatedIds)) {
                        ArticleRelated::create([
                            'ArticleRelated' => [
                                'article_id' => $model->id,
                                'related_id' => $related_id
                            ]
                        ]);
                    }
                }
                foreach ($oldRelatedIds as $related_id) {
                    if (!in_array($related_id, $model->related_ids)) {
                        ArticleRelated::findOne(['article_id' => $model->id, 'related_id' => $related_id])->delete();
                    }
                }

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
     * Deletes an existing Article model.
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
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
