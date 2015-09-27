<?php

namespace modules\site\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Register form
 */
class Register extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique',
                'targetClass' => '\common\models\User',
                'targetAttribute' => 'email',
                'filter' => ['not', ['status' => User::STATUS_NEW]],
                'message' => 'This email address has already been taken.'
            ],
       ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
