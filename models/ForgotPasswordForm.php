<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ForgotPasswordForm extends Model
{
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'email'],
        ];
    }
}
