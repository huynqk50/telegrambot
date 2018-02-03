<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\User;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'Tên đăng nhập',
            'password' => 'Mật khẩu',
            'rememberMe' => 'Ghi nhớ',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Sai tên đăng nhập hoặc mật khẩu.');
            } else if ($user && $user->isInactive()) {
                $this->addError($attribute, 'Tài khoản chưa được kích hoạt.'
                        . ' Vui lòng kiểm tra email để được hướng dẫn.'
                        . ' Hoặc đi đến địa chỉ '
                        . Url::to(['site/request-account-activation'], true)
                        . ' để yêu cầu gửi lại email hướng dẫn kích hoạt.'
                    );
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Customer::findByUsername($this->username);
        }

        return $this->_user;
    }
}
