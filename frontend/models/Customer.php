<?php

namespace frontend\models;

use common\models\Customer as CommonCustomer;
use common\utils\FileUtils;
use frontend\models\CustomerLog;
use himiklab\yii2\recaptcha\ReCaptchaValidator;
use udokmeci\yii2PhoneValidator\PhoneValidator;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\UploadedFile;
/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $email
 * @property string $phone_number
 * @property string $address
 * @property string $firstname
 * @property string $lastname
 * @property integer $dob
 * @property integer $gender
 * @property string $image
 * @property string $image_path
 * @property integer $language_id
 * @property string $zip_postal_code
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $total_purchase_orders
 * @property integer $total_purchase_products
 * @property integer $total_purchase_value
 *
 * @property CustomerLog[] $customerLogs
 */
class Customer extends CommonCustomer
{
    public function getLink()
    {
        return Url::to(['customer/index', UrlParam::USERNAME => $this->username], true);
    }
    
    public function getUpdateLink()
    {
        return Url::to(['customer/update'], true);
    }
    
    public function getUpdatePasswordLink()
    {
        return Url::to(['customer/update-password'], true);
    }
    
    public function img($params = array(), $suffix = null) {
        $result = '';
        if ($this->image !== '') {
            $result = "<img title=\"" . str_replace("\"", "'", $this->username) . "\" alt=\"" . str_replace("\"", "'", $this->username) . "\"";
            $has_src = false;
            $has_schema = false;
            foreach ($params as $attr => $val) {
                    $result .= " $attr=\"$val\"";
                if ($attr === 'src') {
                    $has_src = true;
                }
                if (!$has_schema && in_array($attr, ['itemprop', 'itemscope', 'itemtype'])) {
                    $has_schema = true;
                }
            }
            if (!$has_schema) {
                $result .= " itemprop=\"image\" ";
            }
            if ($suffix !== null) {
                $result .= "src=\"{$this->getImage($suffix, true)}\">";
            } else {
                $result .= "src=\"{$this->getImage()}\">";
            }
        }
        
        return $result;
    }
    
    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $model = new Customer();
        if($model->load($data)) {
            
            $model->created_at = $now;
            $model->dob = strtotime($model->dob);
            $model->status = parent::STATUS_INACTIVE;
            
            if (strpos($model->phone_number, '0') === 0) {
                $model->phone_number = substr($model->phone_number, 1);
                $model->phone_number = "+84 $model->phone_number";
            }
            
            if ($model->password != '') {
                $model->generateActivationToken();
                $model->generateAuthKey();
                $model->setPassword($model->password);

                /*
                 * Upload image
                 */
                $model->image_file = UploadedFile::getInstance($model, 'image_file');
                if ($model->image_file !== null) {
                    /*
                     * Save uploaded image to uploads folder
                     */
                    $file_name = $model->image_file->baseName . '-' . uniqid() . '.' . $model->image_file->extension;
                    $model->image_file->saveAs(Yii::$app->params['uploads_folder'] . "/$file_name" );
                    $from_folder = Yii::$app->params['uploads_folder'];
                    $remove_input = true;
//                } else {
//                    $file_name = rand(1, 5) . '.jpg';
//                    $from_folder = Yii::$app->params['images_folder'] . '/u/d';
//                    $remove_input = false;
//                }

                    /*
                     * Move image to images folder and get image name
                     */
                    $model->image_path = '/u' . FileUtils::generatePath($now, Yii::$app->params['images_folder']);
                    $target_folder = Yii::$app->params['images_folder'] . $model->image_path;

                    $copy_result = FileUtils::copyImage([
                        'imageName' => $file_name,
                        'fromFolder' => $from_folder,
                        'toFolder' => $target_folder,
                        'resize' => array_values(self::$image_resizes),
                        'resizeType' => 2,
                        'removeInputImage' => $remove_input,
                    ]);

                    $model->image = $copy_result['imageName'];
                    $model->image_file = null;
                }
                $model->save();
            }
            
            return $model;
        }
        
        return false;
    }
    
    /**
    * function ->update2 ($data)
    */
    public function update2 ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;   
        if ($this->load($data)) {
            /*
             * DO NOT CHANGE
             * 
             * username,
             * status,
             * email,
             * 
             */
            
            $this->username = $this->getOldAttribute('username');
            $this->status = $this->getOldAttribute('status');
            $this->email = $this->getOldAttribute('email');
            
            $this->updated_at = $now;
            $this->dob = strtotime($this->dob);
            
            if (strpos($this->phone_number, '0') === 0) {
                $this->phone_number = substr($this->phone_number, 1);
                $this->phone_number = "+84 $this->phone_number";
            }
            if (empty($this->password) || $this->validatePassword($this->password)) {
                if (!empty($this->new_password) && $this->scenario == static::SCENARIO_UPDATE_PASSWORD) {
                    if ($this->new_password == $this->password) {
                        $this->addError('new_password', 'Mật khẩu cũ và mật khẩu mới không được trùng nhau.');
                        return false;
                    }
                    $this->setPassword($this->new_password);
                }
                
                $this->generateAuthKey();
                
                /*
                 * Update image
                 */
                $this->image_file = UploadedFile::getInstance($this, 'image_file');
                if ($this->image_file !== null) {
                    /*
                     * Save uploaded image to uploads folder
                     */
                    $file_name = $this->image_file->baseName . '-' . uniqid() . '.' . $this->image_file->extension;
                    $this->image_file->saveAs(Yii::$app->params['uploads_folder'] . "/$file_name" );

                    /*
                     * Move image to images folder and get image name
                     */
                    if ($this->image_path == null || trim($this->image_path) == '' || !is_dir(Yii::$app->params['images_folder'] . $this->image_path)) {
                        $this->image_path = '/u' . FileUtils::generatePath($now, Yii::$app->params['images_folder']);
                    }
                    $target_folder = Yii::$app->params['images_folder'] . $this->image_path;

                    $copy_result = FileUtils::updateImage([
                        'imageName' => $file_name,
                        'oldImageName' => $this->getOldAttribute('image'),
                        'fromFolder' => Yii::$app->params['uploads_folder'],
                        'toFolder' => $target_folder,
                        'resize' => array_values(self::$image_resizes),
                        'resizeType' => 2,
                        'removeInputImage' => true,
                    ]);

                    $this->image = $copy_result['imageName'];
                    $this->image_file = null;
                }
                
                if ($this->save()) {
                    return true;
                }
            } else {
                $this->addError('password', 'Sai mật khẩu.');
            }
        }
        return false;
    }
    
    public $captcha;
    public $password;
    public $confirm_password;
    public $new_password;    
    public $confirm_new_password;
    public $image_file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'email', 'created_at'], 'required'],
            [['gender', 'language_id', 'status', 'total_purchase_orders', 'total_purchase_products', 'total_purchase_value'], 'integer'],
            [['created_at', 'updated_at', 'dob'], 'safe'],
            [['username', 'password', 'password_hash', 'password_reset_token', 'activation_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['phone_number', 'zip_postal_code'], 'string', 'max' => 25],
            [['address', 'firstname', 'lastname', 'image', 'image_path'], 'string', 'max' => 511],
            [['username', 'email', 'phone_number'], 'filter', 'filter' => 'trim'],
            [['username', 'email', 'password_reset_token', 'activation_token'], 'unique'],
            ['email', 'email'],
            ['image_file', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 2 * 1024 * 1024],
            ['phone_number', PhoneValidator::className(), 'country' => 'VI'],
            
            /* On Scenario */
            ['password', 'required', 'on' => [static::SCENARIO_CREATE, static::SCENARIO_UPDATE_PASSWORD]],
            ['password', 'safe', 'on' => static::SCENARIO_UPDATE],
            ['password', 'string', 'min' => 6, 'max' => 100, 'on' => static::SCENARIO_CREATE],
            ['new_password', 'string', 'min' => 6, 'max' => 100, 'on' => static::SCENARIO_UPDATE_PASSWORD],
            [['confirm_password'/*, 'captcha'*/], 'required', 'on' => static::SCENARIO_CREATE],
            [['new_password', 'confirm_new_password'], 'required', 'on' => static::SCENARIO_UPDATE_PASSWORD],
            [
                'confirm_password',
                'compare',
                'compareAttribute' => 'password',
                'operator' => '==',
                'message' => 'Mật khẩu không khớp.',
                'on' => static::SCENARIO_CREATE
            ],
            [
                'confirm_new_password',
                'compare',
                'compareAttribute' => 'new_password',
                'operator' => '==',
                'message' => 'Mật khẩu không khớp.',
                'on' => static::SCENARIO_UPDATE_PASSWORD
            ],
            [
                'captcha',
                 ReCaptchaValidator::className(),
                'secret' => Yii::$app->params['recaptcha.secret_key'],
                'on' => static::SCENARIO_CREATE
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Tên đăng nhập',
            'password' => 'Mật khẩu',
            'confirm_password' => 'Xác minh mật khẩu',
            'new_password' => 'Mật khẩu mới',
            'confirm_new_password' => 'Xác minh mật khẩu mới',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'email' => 'Email',
            'phone_number' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'firstname' => 'Tên',
            'lastname' => 'Họ',
            'dob' => 'Ngày sinh',
            'gender' => 'Giới tính',
            'image' => 'Ảnh đại diện',
            'image_path' => 'Image Path',
            'language_id' => 'Ngôn ngữ',
            'zip_postal_code' => 'Zip Postal Code',
            'status' => 'Trạng thái',
            'created_at' => 'Thời gian đăng ký',
            'updated_at' => 'Cập nhật lần cuối',
            'total_purchase_orders' => 'Tổng số đơn hàng',
            'total_purchase_products' => 'Tổng số sản phẩm',
            'total_purchase_value' => 'Tổng giá trị thanh toán',
            'captcha' => 'Mã xác thực',
            'image_file' => 'Ảnh đại diện',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomerLogs()
    {
        return $this->hasMany(CustomerLog::className(), ['username' => 'username']);
    }
}
