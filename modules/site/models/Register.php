<?php

namespace modules\site\models;

use common\events\UserEvent;
use common\models\UserRecord as User;
use yii\base\Exception;
use yii\base\Model;
use Yii;

/**
 * Register model
 */
class Register extends Model
{
    const EVENT_USER_REGISTER   = 'user.register';

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
                'targetClass' => '\common\models\UserRecord',
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
     * @throws UserUnableRegisterException
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->generateAuthKey();

            if ($user->save()) {
                \Yii::$app->trigger(self::EVENT_USER_REGISTER, new UserEvent($user));
                return $user;
            }
        }
    }
}
