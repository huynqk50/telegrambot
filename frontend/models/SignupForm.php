<?php
namespace frontend\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $firstname;
    public $lastname;
    public $username;
    public $email;
    public $password;
    public $confirm_password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['firstname', 'lastname'], 'string', 'min' => 2, 'max' => 255],
            
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\frontend\models\Customer', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\frontend\models\Customer', 'message' => 'This email address has already been taken.'],

            [['password', 'confirm_password'], 'required'],
            [['password', 'confirm_password'], 'string', 'min' => 6],
            
            [
                'confirm_password',
                'compare',
                'compareAttribute' => 'password',
                'operator' => '==',
                'message' => 'Password not confirmed',
            ],            
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new Customer();
            $user->created_at = strtotime('now');
            $user->status = Customer::STATUS_ACTIVE;
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
