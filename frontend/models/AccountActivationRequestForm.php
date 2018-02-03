<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class AccountActivationRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\frontend\models\Customer',
                'filter' => ['status' => Customer::STATUS_INACTIVE],
                'message' => 'Không tìm thấy tài khoản đang chờ kích hoạt tương ứng với email bạn cung cấp.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user Customer */
        $user = Customer::findOne([
            'status' => Customer::STATUS_INACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!Customer::isActivationTokenValid($user->activation_token)) {
                $user->generateActivationToken();
            }
            
            if ($user->save()) {
                return Yii::$app->mailer->compose(['html' => 'accountActivationToken-html', 'text' => 'accountActivationToken-text'], ['user' => $user])
                    ->setFrom([Yii::$app->params['noreplyEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject("Kích hoạt tài khoản cho $user->username")
                    ->send();
            } else {
                var_dump($user->errors);
            }
        }

        return false;
    }
}
