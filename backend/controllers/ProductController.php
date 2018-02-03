<?php

namespace backend\controllers;

use backend\models\ProductToAttribute;
use backend\models\ProductImage;
use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\controllers\BaseController;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\ProductRelated;
use yii\helpers\ArrayHelper;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseController
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Url::remember();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $username = Yii::$app->user->identity->username;
        $model = new Product();
        
        if (Yii::$app->request->isPost && $model = Product::create(Yii::$app->request->post())) {
            // @TODO: Upload product images and save record into database
            $model->image_files = UploadedFile::getInstances($model, 'image_files');
            foreach ($model->image_files as $file) {
                if ($file->saveAs(Yii::$app->params['uploads_folder'] . "/$file->name")) {
                    ProductImage::create([
                        Html::getInputId(new ProductImage(), 'image') => $file->name,
                        'ProductImage' => [
                            'product_id' => $model->id,
                            'image' => $file->name
                        ]
                    ]);
                }
            }

            // @TODO: Create related products
            is_array($model->related_ids) or $model->related_ids = [];
            foreach ($model->related_ids as $related_id) {
                ProductRelated::create([
                    'ProductRelated' => [
                        'product_id' => $model->id,
                        'related_id' => $related_id
                    ]
                ]);
            }

            // @TODO: Create product - attribute references
            is_array($model->attribute_ids) or $model->attribute_ids = [];
            foreach ($model->attribute_ids as $attribute_id) {
                ProductToAttribute::create([
                    'ProductToAttribute' => [
                        'product_id' => $model->id,
                        'attribute_id' => $attribute_id
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
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $username = Yii::$app->user->identity->username;
        if ($model = $this->findModel($id)) {
            $this->product_id = $model->id;

            // @TODO: Remember old related product ids
            $model->related_ids = ArrayHelper::getColumn(ProductRelated::findAll(['product_id' => $model->id]), 'related_id', false);
            $oldRelatedIds = $model->related_ids;

            // @TODO: Remember old product to attribute ids
            $model->attribute_ids = ArrayHelper::getColumn(ProductToAttribute::findAll(['product_id' => $model->id]), 'attribute_id', false);
            $oldAttributeIds = $model->attribute_ids;

            if (Yii::$app->request->isPost &&  $model->update2(Yii::$app->request->post())) {
                // @TODO: Upload new image files
                $model->image_files = UploadedFile::getInstances($model, 'image_files');
                foreach ($model->image_files as $file) {
                    if ($file->saveAs(Yii::$app->params['uploads_folder'] . "/$file->name")) {
                        ProductImage::create([
                            Html::getInputId(new ProductImage(), 'image') => $file->name,
                            'ProductImage' => [
                                'product_id' => $model->id,
                                'image' => $file->name
                            ]
                        ]);
                    }
                }

                // @TODO: Update related products
                is_array($model->related_ids) or $model->related_ids = [];
                foreach ($model->related_ids as $related_id) {
                    if (!in_array($related_id, $oldRelatedIds)) {
                        ProductRelated::create([
                            'ProductRelated' => [
                                'product_id' => $model->id,
                                'related_id' => $related_id
                            ]
                        ]);
                    }
                }
                foreach ($oldRelatedIds as $related_id) {
                    if (!in_array($related_id, $model->related_ids)) {
                        ProductRelated::findOne(['product_id' => $model->id, 'related_id' => $related_id])->delete();
                    }
                }

                // @TODO: Update product - attribute references
                is_array($model->attribute_ids) or $model->attribute_ids = [];
                foreach ($model->attribute_ids as $attribute_id) {
                    if (!in_array($attribute_id, $oldAttributeIds)) {
                        ProductToAttribute::create([
                            'ProductToAttribute' => [
                                'product_id' => $model->id,
                                'attribute_id' => $attribute_id
                            ]
                        ]);
                    }
                }
                foreach ($oldAttributeIds as $attribute_id) {
                    if (!in_array($attribute_id, $model->attribute_ids)) {
                        ProductToAttribute::findOne(['product_id' => $model->id, 'attribute_id' => $attribute_id])->delete();
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

    public function actionAjaxDeleteProductImage()
    {
        $result = [];
        $id = Yii::$app->request->getBodyParam('key');
        $product_image = ProductImage::findOne($id);
        if ($product_image) {
            $product_image->delete();
        } else {
            $result['error'] = ['Model not found.'];
        }
        return json_encode($result);
    }

    /**
     * Deletes an existing Product model.
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
        return $this->goBack(Url::previous());
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
