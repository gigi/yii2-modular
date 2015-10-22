<?php

namespace modules\site\models;

use Yii;
use common\events\UserEvent;
use common\models\UserRecord as User;
use common\base\Model;

/**
 * Register model
 */
class Register extends Model
{
    const EVENT_USER_REGISTER = 'mediator.user.register';

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
            ['email', 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\UserRecord',
                'targetAttribute' => 'email',
                'filter' => ['not', ['status' => User::STATUS_NEW]],
                'message' => 'This email address has already been taken.'
            ],
        ];
    }

    /**
     * User's signs up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->email = $this->email;
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        if (User::removeTokenByEmail($user->email) && $user->save()) {
            static::getCurrentModule()->sendMessage(self::EVENT_USER_REGISTER, new UserEvent($user));

            return $user;
        }
    }
}
