<?php
namespace backend\controllers;

use backend\controllers\BaseController;
use backend\models\UserLog;
use backend\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\User;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => [
                        'post',
                        'get',
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        // User Logs
        $logs = UserLog::find()->where(['in', 'action', ['Create', 'Update', 'Delete']])->andWhere(['is_success' => 1])->andWhere(['>=', 'created_at', strtotime(date('Y-m-d 00:00:00'))])->orderBy('id desc')->all();
        $statistics = [];
        foreach ($logs as $log) {
//            $item = [
//                'user' => null,
//                'actions' => [
//                    'create' => [
//                        't_action' => 'Thêm',
//                        'objects' => [[
//                            'time' => date('H:i', $log->created_at),
//                            'class' => '',
//                            'name' => '',
//                            't_name' => '',
//                            'model' => null,
//                        ]],
//                    ],
//                    'update' => [
//                        't_action' => 'Sửa',
//                        'objects' => [[
//                            'time' => date('H:i', $log->created_at),
//                            'class' => '',
//                            'name' => '',
//                            't_name' => '',
//                            'model' => null,
//                        ]],
//                    ],
//                    'delete' => [
//                        't_action' => 'Xóa',
//                        'objects' => [[
//                            'time' => date('H:i', $log->created_at),
//                            'class' => '',
//                            'name' => '',
//                            't_name' => '',
//                            'model' => null,
//                        ]],
//                    ],
//                ],
//            ];
            
            $user = User::findOne(['username' => $log->username]);
            if (!$user) {
                continue;
            }
            if (isset($statistics[$log->username])) {
                $item = $statistics[$log->username];
            } else {
                $item = [
                    'user' => $user,
                    'actions' => [
                        'create' => [
                            't_action' => 'Thêm',
                            'objects' => []
                        ],
                        'update' => [
                            't_action' => 'Sửa',
                            'objects' => []
                        ],
                        'delete' => [
                            't_action' => 'Xóa',
                            'objects' => []
                        ]
                    ]
                ];
            }
            $object['class'] = '\backend\models\\' . $log->object_class;
            if (!class_exists($object['class'])) {
                continue;
            }
            
            if (!method_exists($object['class'], 'getLink')) {
                continue;
            }
            
            $object['time'] = date('H:i', $log->created_at);
            $object['name'] = $log->object_class;
            switch ($object['name']) {
                case 'Article':
                    $object['t_name'] = 'Tin tức';
                    break;
                case 'ArticleCategory':
                    $object['t_name'] = 'Danh mục tin tức';
                    break;
                case 'SeoInfo':
                    $object['t_name'] = 'Thông tin SEO';
                    break;
                default:
                    $object['t_name'] = $object['name'];
            }
            switch ($log->action) {
                case 'Create':
                    if (!$object['model'] = $object['class']::findOne(['id' => $log->object_pk])) {
                        $object['model'] = null;
                        if ($delete_log = UserLog::findOne([
                            'action' => 'Delete',
                            'object_class' => $log->object_class,
                            'object_pk' => $log->object_pk
                        ])) {
                            $object['deleted_by'] = $delete_log->username;
                        } else {
                            $object['deleted_by'] = null;
                        }
                    }
                    $item['actions']['create']['objects'][] = $object;
                    break;
                case 'Update':
                    if (!$object['model'] = $object['class']::findOne(['id' => $log->object_pk])) {
                        $object['model'] = null;
                        if ($delete_log = UserLog::findOne([
                            'action' => 'Delete',
                            'object_class' => $log->object_class,
                            'object_pk' => $log->object_pk
                        ])) {
                            $object['deleted_by'] = $delete_log->username;
                        } else {
                            $object['deleted_by'] = null;
                        }
                    }
                    $item['actions']['update']['objects'][] = $object;
                    break;
                case 'Delete':
                    $object['model'] = null;
                    $object['deleted_by'] = null;
                    $item['actions']['delete']['objects'][] = $object;
                    break;
                default:
            }
            
            $statistics[$log->username] = $item;
        }
        
        return $this->render('index', [
            'statistics' => $statistics,
        ]);
    }

    public function actionLogin()
    {
//        $this->layout = false;
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
