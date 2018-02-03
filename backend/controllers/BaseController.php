<?php
namespace backend\controllers;

use backend\models\ArticleCategory;
use backend\models\Tag;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\Controller;
/**
 * Base controller
 */
class BaseController extends Controller {
    public $product_id, $purchase_order_id;
    
    public function init() {
        parent::init();
        
    }
    
    public function beforeAction($action) {
        parent::beforeAction($action);

        Yii::$app->session->set('uploaded_filenames', []);
        Yii::$app->session->set('model_name', Inflector::id2camel(Yii::$app->controller->id));
        Yii::$app->session->set('model_id', Yii::$app->request->get('id', ''));

        return true;
    }
    
}
