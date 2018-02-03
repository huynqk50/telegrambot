<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
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
                'filter' => ['status' => Customer::STATUS_ACTIVE],
                'message' => 'Không tìm thấy email.'
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
            'status' => Customer::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!Customer::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
                    ->setFrom([Yii::$app->params['noreplyEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject("Đặt lại mật khẩu cho $user->username")
                    ->send();
            } else {
                var_dump($user->errors);
            }
        }

        return false;
    }
}
