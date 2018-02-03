<?php
namespace frontend\controllers;

use common\models\User;
use frontend\models\AccountActivationRequestForm;
use frontend\models\ContactForm;
use frontend\models\Customer;
use frontend\models\Info;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\Redirect;
use frontend\models\ResetPasswordForm;
use frontend\models\UrlParam;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use const YII_ENV_TEST;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->link_canonical = Url::home(true);

//        $featured_news = array_merge(
//            Article::find()->where(['status' => Article::STATUS_HOT])
//                ->orderBy('published_at desc')->limit(1)->allPublished(),
//
//            Article::find()->where(['status' => Article::STATUS_FEATURED])
//                ->orderBy('published_at desc')->limit(11)->allPublished()
//        );
//
//        $football_teams = ArticleCategory::findAllByTypes([ArticleCategory::TYPE_FOOTBALL_TEAM]);
//
//        $categories = [];
//        foreach (ArticleCategory::indexData() as $item) {
//            if (count($item->findChildren()) == 0) {
//                $categories[] = $item;
//            }
//        }

        return $this->render('index', [
//            'featured_news' => $featured_news,
//            'football_teams' => $football_teams,
//            'categories' => $categories,
        ]);
    }
    
    public function actionRedirect()
    {
        return Redirect::go();
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
            
        if (!$this->seo_exist) {
            $this->page_title = $this->meta_title = $this->h1 = 'Đăng nhập';
            $this->meta_description = 'Đăng nhập';
            $this->meta_keywords = 'Đăng nhập, dang nhap';
        }
            
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
//    public function actionContact()
//    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
//                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
//            } else {
//                Yii::$app->session->setFlash('error', 'There was an error sending email.');
//            }
//
//            return $this->refresh();
//        } else {
//            return $this->render('contact', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $model = Info::find()->where(['type' => Info::TYPE_PROFILE])->one();
        $members = User::find()->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')->where(['auth_assignment.item_name' => User::ROLE_FOUNDER])->all();
//        var_dump($members);die();
        return $this->render('about', ['model' => $model, 'members' => $members]);
    }
    
    public function actionService()
    {
        $model = Info::find()->where(['type' => Info::TYPE_SERVICES])->one();
//        var_dump($members);die();
        return $this->render('service', ['model' => $model]);
    }
    

    /**
     * Signs user up.
     *
     * @return mixed
     */
//    public function actionSignup()
//    {
//        $model = new SignupForm();
//        if ($model->load(Yii::$app->request->post())) {
//            if ($user = $model->signup()) {
//                if (Yii::$app->getUser()->login($user)) {
//                    return $this->goHome();
//                }
//            }
//        }
//        return $this->render('signup', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('message', 'Chúng tôi vừa gửi đến bạn một email, vui lòng kiểm tra để được hướng dẫn cách tạo lại mật khẩu.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('message', 'Có lỗi khi gửi email. Hãy chắc chắn email bạn nhập là chính xác.');
            }
        }
        
        if (!$this->seo_exist) {
            $this->page_title = $this->meta_title = $this->h1 = 'Nhập thông tin email để nhận lại mật khẩu';
            $this->meta_description = 'Nhập thông tin email để nhận lại mật khẩu';
            $this->meta_keywords = 'Nhập thông tin email để nhận lại mật khẩu, Nhap thong tin email de nhan lai mat khau';
        }
        
        $this->breadcrumbs[] = ['label' => 'Quên mật khẩu', 'url' => Url::current([], true)];

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword()
    {
        $token = Yii::$app->request->get(UrlParam::TOKEN);
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Đã lưu mật khẩu mới.');

            return $this->goHome();
        }
        
        $this->meta_follow = 'nofollow';
        $this->meta_index = 'noindex';
        $this->page_title = $this->meta_title = $this->h1 = 'Đặt lại mật khẩu mới';
        $this->meta_description = 'Đặt lại mật khẩu mới';
        $this->meta_keywords = 'Đặt lại mật khẩu mới, dat lai mat khau moi';

        $this->breadcrumbs[] = ['label' => 'Đặt lại mật khẩu', 'url' => Url::current([], true)];
        
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    public function actionActivateAccount()
    {
        $token = Yii::$app->request->get(UrlParam::TOKEN);
        if (empty($token) || !is_string($token)) {
            throw new BadRequestHttpException;
        }
        if (!$user = Customer::findByActivationToken($token)) {
            throw new NotFoundHttpException;
        }
        
        $user->removeActivationToken();
        
        $user->status = Customer::STATUS_ACTIVE;
        $user->save(false);
        
        Yii::$app->user->login($user);
        
        $this->meta_follow = 'nofollow';
        $this->meta_index = 'noindex';
        $this->page_title = $this->meta_title = $this->h1 = 'Kích hoạt tài khoản';
        $this->meta_description = 'Kích hoạt tài khoản';
        $this->meta_keywords = 'Kích hoạt tài khoản, kich hoat tai khoan';
        
        return $this->render('activateAccount');
    }
    
    public function actionRequestAccountActivation()
    {
        $model = new AccountActivationRequestForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('message', 'Chúng tôi vừa gửi đến bạn một email, vui lòng kiểm tra để được hướng dẫn cách kích hoạt tài khoản.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('message', 'Có lỗi khi gửi email.');
            }
        }
        
        if (!$this->seo_exist) {
            $this->page_title = $this->meta_title = $this->h1 = 'Nhập thông tin email để kích hoạt tài khoản';
            $this->meta_description = 'Nhập thông tin email để kích hoạt tài khoản';
            $this->meta_keywords = 'Nhập thông tin email để kích hoạt tài khoản, Nhap thong tin email de kich hoat tai khoan';
        }
        
        $this->breadcrumbs[] = ['label' => 'Kích hoạt tài khoản', 'url' => Url::current([], true)];
        
        return $this->render('requestAccountActivationToken', [
            'model' => $model,
        ]);
    }
}
