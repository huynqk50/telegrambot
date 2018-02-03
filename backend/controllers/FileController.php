<?php
namespace backend\controllers;

use common\utils\FileUtils;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;

/* 
 * File controller
 */
class FileController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }
    public function actionCkeditorUploadImage() {
        $file_input_name = 'upload';
        $check = getimagesize($_FILES[$file_input_name]["tmp_name"]);
        if($check === false) {
            echo 'File is not an image.';
            return false;
        }

        $uploadedFile = UploadedFile::getInstanceByName($file_input_name);
        $filename = $uploadedFile->baseName;
        foreach (FileUtils::$file_name_replace as $search => $replace){
            $filename = str_replace(html_entity_decode($search), $replace, $filename);
        }
        if (trim($filename) == ''){
            $filename = 'Untitle';
        }
        $filename .= '.' . $uploadedFile->extension;
        $prefix = '';
        
        do {
            $targetUrl = Yii::$app->params['uploads_url'] . '/' . $prefix . $filename;
            $targetPath = Yii::$app->params['uploads_folder'] . '/' . $prefix . $filename;
            $prefix .= ' ';
        } while (is_file($targetPath));
        
        if ($uploadedFile === null || $uploadedFile->size === 0 || $uploadedFile->tempName === '') {
            $message = 'Không có ảnh nào được tải lên.';
        } else if (!in_array(strtolower($uploadedFile->extension), FileUtils::$allow_extensions)) {
            $message = 'Ảnh không đúng định dạng (' . implode(', ', FileUtils::$allow_extensions) . ').';
        } else {
            if (!is_dir(Yii::$app->params['uploads_folder'])){
                mkdir(Yii::$app->params['uploads_folder'], 0755, true);
            }
//            if (static::checkFileExits($filename)) {
//                $message = 'Ảnh bị trùng tên, vui lòng tải ảnh có tên khác!';
//            } else
                if (!$uploadedFile->saveAs($targetPath)) {
                $message = 'Không lưu được ảnh, vui lòng thử lại!';
            } else {
                $message = 'Tải lên thành công!';
            }
        }
        $funcNum = Yii::$app->request->get('CKEditorFuncNum');
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$targetUrl', '$message');</script>";
    }
    
    public function actionCheckFileExists()
    {
        
        $file_name = Yii::$app->request->post('image_name', '');
        
        return static::checkFileExits($file_name)
            ? 1
            : 0;

    }

    public function actionGetUploadFileName()
    {
        $file_name = Yii::$app->request->post('image_name', '');

        $prefix = '';
        do {
            $targetPath = Yii::$app->params['uploads_folder'] . '/' . $prefix . $file_name;
            $prefix .= ' ';
        } while (is_file($targetPath));

        return $file_name;
    }
    
    public static function checkFileExits($filename = '')
    {
        $key = 'uploaded_filenames';
        
        $uploaded_filenames = Yii::$app->session->get($key, []);
        
        if (in_array($filename, $uploaded_filenames)) {
            return true;
        }
        
        $path = '';
        
        $model_name = Yii::$app->session->get('model_name', '');
        $model_id = Yii::$app->session->get('model_id', '');
        
        if ($model_name != '' && $model_id != '') {
            $class_name = "\\backend\\models\\$model_name";
            if (class_exists($class_name)) {
                $model = $class_name::findOne($model_id);
                if ($model) {
                    if (isset($model->image_path)) {
                        $path = $model->image_path;
                    }
                }
            }
        }
        
        if ($path == '') {
            $path = FileUtils::generatePath(time(), Yii::$app->params['images_folder']);
        }
        
        if ($path != '' && $filename != '') {
            $container = Yii::$app->params['images_folder'] . $path;
            if (FileUtils::fileWithSuffixesExists($container, $filename)) {
                return true;
            }
        }
        
        $uploaded_filenames[] = $filename;
        
        Yii::$app->session->set($key, $uploaded_filenames);
        
        return false;
    }
    
}

