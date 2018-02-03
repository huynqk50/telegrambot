<?php

namespace backend\controllers;

use Yii;
use backend\models\Video;
use backend\models\VideoSearch;
use backend\models\VideoRelated;
use yii\helpers\ArrayHelper;
use backend\controllers\BaseController;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VideoController implements the CRUD actions for Video model.
 */
class VideoController extends BaseController
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
     * Lists all Video models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VideoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Url::remember();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Video model.
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
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $username = Yii::$app->user->identity->username;
        $model = new Video();
        
        if (Yii::$app->request->isPost && $model = Video::create(Yii::$app->request->post())) {
            is_array($model->related_ids) or $model->related_ids = [];

            foreach ($model->related_ids as $related_id) {
                VideoRelated::create([
                    'VideoRelated' => [
                        'video_id' => $model->id,
                        'related_id' => $related_id
                    ]
                ]);
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }
        
        return $this->render('create', [
            'username' => $username,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $username = Yii::$app->user->identity->username;
        
        $model = $this->findModel($id);

        $model->related_ids = ArrayHelper::getColumn(VideoRelated::findAll(['video_id' => $model->id]), 'related_id', false);
        $oldRelatedIds = $model->related_ids;

        if (Yii::$app->request->isPost && $model->update2(Yii::$app->request->post())) {
            is_array($model->related_ids) or $model->related_ids = [];
            
            foreach ($model->related_ids as $related_id) {
                if (!in_array($related_id, $oldRelatedIds)) {
                    VideoRelated::create([
                        'VideoRelated' => [
                            'video_id' => $model->id,
                            'related_id' => $related_id
                        ]
                    ]);
                }
            }
            
            foreach ($oldRelatedIds as $related_id) {
                if (!in_array($related_id, $model->related_ids)) {
                    VideoRelated::findOne(['video_id' => $model->id, 'related_id' => $related_id])->delete();
                }
            }
            
            return $this->goBack(Url::previous());
        }
        
        return $this->render('update', [
            'username' => $username,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Video model.
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
     * Finds the Video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
