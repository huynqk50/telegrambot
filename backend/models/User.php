<?php

namespace backend\models;

use common\utils\FileUtils;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $firstname
 * @property string $lastname
 * @property integer $dob
 * @property string $alias
 * @property integer $gender
 * @property string $image
 * @property string $image_path
 *
 * @property UserLog[] $userLogs
 */
class User extends \common\models\User
{
    
    

    /**
    * function ->getImage ($suffix, $refresh)
    */
    public $_image;
    public function getImage ($suffix = null, $refresh = false)
    {
        if ($this->_image === null || $refresh == true) {
            $this->_image = FileUtils::getImage([
               'imageName' => $this->image,
               'imagePath' => $this->image_path,
               'imagesFolder' => Yii::$app->params['images_folder'],
               'imagesUrl' => Yii::$app->params['images_url'],
               'suffix' => $suffix,
               'defaultImage' => Yii::$app->params['backend_url'] . '/admin-lte/dist/img/ava_love.jpg'
           ]);
        }
        return $this->_image;
    }

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new User();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = 'User';
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            $model->created_at = $now;
            
            $model->dob = strtotime($model->dob);

	
            $model->image_path = FileUtils::generatePath($now, Yii::$app->params['images_folder']);

            $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $model->image_path;
            
            if (!empty($data['user-image'])) {
                $copyResult = FileUtils::copyImage([
                    'imageName' => $model->image,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$image_resizes),
                    'resizeType' => 2,
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $model->image = $copyResult['imageName'];
                }
            }
        
            // User class
            $model->generateAuthKey();
            $model->setPassword($model->password);
            
            if ($model->save()) {
                if ($log) {
                    $log->object_pk = $model->id;
                    $log->is_success = 1;
                    $log->save();
                }
                return $model;
            }
            $model->getErrors();
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
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Update';
                $log->object_class = 'User';
                $log->object_pk = $this->id;
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
            
            $this->updated_at = $now;
            
            $this->dob = strtotime($this->dob);
                  
            if ($this->image_path == null || trim($this->image_path) == '' || !is_dir(Yii::$app->params['images_folder'] . $this->image_path)) {
                $this->image_path = FileUtils::generatePath($now, Yii::$app->params['images_folder']);
            }
           
            $targetFolder = Yii::$app->params['images_folder'] . $this->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $this->image_path;
            
            if (!empty($data['user-image'])) {
                $copyResult = FileUtils::updateImage([
                    'imageName' => $this->image,
                    'oldImageName' => $this->getOldAttribute('image'),
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$image_resizes),
                    'resizeType' => 2,
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $this->image = $copyResult['imageName'];
                }
            }
            
            if ($this->validatePassword($this->password)) {
                if (!empty($this->new_password)) {
                    if ($this->new_password == $this->password) {
                        $this->addError('password', 'New password cannot be same current password');
                        return false;
                    }
                    $this->setPassword($this->new_password);
                }
                $this->generateAuthKey();
                if ($this->save()) {
                    if ($log) {
                        $log->is_success = 1;
                        $log->save();
                    }
                    return true;
                }
                return false;
            } else {
                $this->addError('password', 'Password incorrect');
            }
            return false;
        }
        return false;
    }
    
    /**
    * function ->delete ()
    */
    public function delete ()
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;    
        if ($log = new UserLog()) {
            $log->username = $username;
            $log->action = 'Delete';
            $log->object_class = 'User';
            $log->object_pk = $this->id;
            $log->created_at = $now;
            $log->is_success = 0;
            $log->save();
        }
        if(parent::delete()) {
            if ($log) {
                $log->is_success = 1;
                $log->save();
            }
            if ($this->image_path != '') {
                $targetFolder = Yii::$app->params['images_folder'] . $this->image_path;
                $targetUrl = Yii::$app->params['images_url'] . $this->image_path;

                FileUtils::updateImage([
                    'imageName' => '',
                    'oldImageName' => $this->image,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$image_resizes),
                ]);

            }
            return true;
        }
        return false;
    }
    
    public $password;
    public $confirm_password;
    public $new_password;    
    public $confirm_new_password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'auth_key', 'password_hash', 'email', 'created_at'], 'required', 'message' => '{attribute} không thể để trống'],
            [['status', 'gender'], 'integer', 'message' => '{attribute} phải là số tự nhiên'],
            [['created_at', 'updated_at', 'dob'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'firstname', 'lastname', 'alias', 'image', 'image_path'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'string', 'min' => 2, 'tooShort' => '{attribute} tối thiểu 2 ký tự'],
            [['username'], 'unique', 'message' => '{attribute} đã tồn tại'],
            [['email'], 'unique', 'message' => '{attribute} đã tồn tại'],
            [['password_reset_token'], 'unique'],
            [['password', 'confirm_password'], 'string', 'min' => 6, 'tooShort' => '{attribute} tối thiểu 6 ký tự', 'on' => 'create'],
            [['new_password', 'confirm_new_password'], 'string', 'min' => 6, 'tooShort' => '{attribute} tối thiểu 6 ký tự', 'on' => 'update'],
            [
                'confirm_password',
                'compare',
                'compareAttribute' => 'password',
                'operator' => '==',
                'message' => 'Mật khẩu không khớp',
                'on' => 'create'
            ],
            [
                'confirm_password',
                'required',
                'on' => 'create'
            ],
            [
                'confirm_new_password',
                'compare',
                'compareAttribute' => 'new_password',
                'operator' => '==',
                'message' => 'Mật khẩu mới không khớp',
                'on' => 'update'
            ],
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
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tham gia',
            'updated_at' => 'Cập nhật lúc',
            'firstname' => 'Tên',
            'lastname' => 'Họ',
            'dob' => 'Ngày sinh',
            'alias' => 'Quote',
            'gender' => 'Tôi là ...',
            'image' => 'Ảnh đại diện',
            'image_path' => 'Đường dẫn ảnh',
            'password' => 'Mật khẩu',
            'new_password' => 'Mật khẩu mới',
            'confirm_password' => 'Nhập lại mật khẩu',
            'confirm_new_password' => 'Nhập lại mật khẩu mới',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserLogs()
    {
        return $this->hasMany(UserLog::className(), ['username' => 'username']);
    }
}
