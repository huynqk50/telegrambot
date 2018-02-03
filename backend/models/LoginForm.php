<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 4/27/2017
 * Time: 5:27 PM
 */

namespace backend\models;


class LoginForm extends \common\models\LoginForm
{
    public $reCaptcha;
    public function rules()
    {
        return array_merge(parent::rules(), [
//            [   ['reCaptcha'],
//                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
//                'secret' => '6Lew-x4UAAAAAMO2AkKt5eHRLC6e0grKw6QV82te',
//                'uncheckedMessage' => 'Please confirm that you are not a bot.'
//            ]
        ]);
    }
}