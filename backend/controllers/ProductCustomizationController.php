<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductCustomization;
use backend\models\ProductCustomizationSearch;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\ProductCustomizationToOption;
use backend\models\ProductCustomizationToImage;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use backend\models\ProductImage;
use yii\helpers\Html;

/**
 * ProductCustomizationController implements the CRUD actions for ProductCustomization model.
 */
class ProductCustomizationController extends BaseController
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
     * Lists all ProductCustomization models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductCustomizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->product_id = Yii::$app->request->queryParams['product_id'];

        Url::remember();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductCustomization model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $this->product_id = $model->product_id;
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new ProductCustomization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($product_id)
    {
        $username = Yii::$app->user->identity->username;
        $model = new ProductCustomization();
        $model->product_id = $product_id;
        $this->product_id = $model->product_id;


        if (Yii::$app->request->isPost && $model = ProductCustomization::create(Yii::$app->request->post())) {

            // @TODO: Upload product images and save record of them into database
            $model->image_files = UploadedFile::getInstances($model, 'image_files');
            foreach ($model->image_files as $file) {
                if ($file->saveAs(Yii::$app->params['uploads_folder'] . "/$file->name")) {
                    ProductImage::create([
                        Html::getInputId(new ProductImage(), 'image') => $file->name,
                        'ProductImage' => [
                            'product_id' => $model->product->id,
                            'customization_id' => $model->id,
                            'image' => $file->name
                        ]
                    ]);
                }
            }

            // @TODO: Create customization - option references
            is_array($model->option_ids) or $model->option_ids = [];
            foreach ($model->option_ids as $option_id) {
                ProductCustomizationToOption::create([
                    'ProductCustomizationToOption' => [
                        'customization_id' => $model->id,
                        'option_id' => $option_id
                    ]
                ]);
            }

            // @TODO: Create customization - image references
            is_array($model->image_ids) or $model->image_ids = [];
            foreach ($model->image_ids as $image_id) {
                ProductCustomizationToImage::create([
                    'ProductCustomizationToImage' => [
                        'customization_id' => $model->id,
                        'image_id' => $image_id
                    ]
                ]);
            }

            // @TODO: Update product quantity
            $model->product->updateQuantityAndRevenue();

            return $this->redirect(['index', 'product_id' => $model->product_id]);
        }
        return $this->render('create', [
            'username' => $username,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductCustomization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $username = Yii::$app->user->identity->username;
        $model = $this->findModel($id);
        $this->product_id = $model->product_id;

        // @TODO: Remember old option ids
        $model->option_ids = ArrayHelper::getColumn(ProductCustomizationToOption::findAll(['customization_id' => $model->id]), 'option_id', false);
        $oldOptionIds = $model->option_ids;

        // @TODO: Remember old image ids
        $model->image_ids = ArrayHelper::getColumn(ProductCustomizationToImage::findAll(['customization_id' => $model->id]), 'image_id', false);
        $oldImageIds = $model->image_ids;

        if (Yii::$app->request->isPost && $model->update2(Yii::$app->request->post())) {

            // @TODO: Upload image files
            $model->image_files = UploadedFile::getInstances($model, 'image_files');
            foreach ($model->image_files as $file) {
                if ($file->saveAs(Yii::$app->params['uploads_folder'] . "/$file->name")) {
                    ProductImage::create([
                        Html::getInputId(new ProductImage(), 'image') => $file->name,
                        'ProductImage' => [
                            'product_id' => $model->product->id,
                            'customization_id' => $model->id,
                            'image' => $file->name
                        ]
                    ]);
                }
            }

            // @TODO: Update options
            is_array($model->option_ids) or $model->option_ids = [];
            foreach ($model->option_ids as $option_id) {
                if (!in_array($option_id, $oldOptionIds)) {
                    ProductCustomizationToOption::create([
                        'ProductCustomizationToOption' => [
                            'customization_id' => $model->id,
                            'option_id' => $option_id
                        ]
                    ]);
                }
            }
            foreach ($oldOptionIds as $option_id) {
                if (!in_array($option_id, $model->option_ids)) {
                    ProductCustomizationToOption::findOne(['customization_id' => $model->id, 'option_id' => $option_id])->delete();
                }
            }

            // @TODO: Update images
            is_array($model->image_ids) or $model->image_ids = [];
            foreach ($model->image_ids as $image_id) {
                if (!in_array($image_id, $oldImageIds)) {
                    ProductCustomizationToImage::create([
                        'ProductCustomizationToImage' => [
                            'customization_id' => $model->id,
                            'image_id' => $image_id
                        ]
                    ]);
                }
            }
            foreach ($oldImageIds as $image_id) {
                if (!in_array($image_id, $model->image_ids)) {
                    ProductCustomizationToImage::findOne(['customization_id' => $model->id, 'image_id' => $image_id])->delete();
                }
            }

            // @TODO: Update product quantity
            $model->product->updateQuantityAndRevenue();


            return $this->goBack(Url::previous());
        } else {
            return $this->render('update', [
                'username' => $username,
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductCustomization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            foreach ($model->productImages as $item) {
                $item->delete();
            }
        }
        $this->product_id = $model->product_id;
        return $this->goBack(Url::previous());
    }

    /**
     * Finds the ProductCustomization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductCustomization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductCustomization::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
