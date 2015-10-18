<?php

namespace modules\site\models;

use common\events\UserEvent;
use common\models\UserRecord as User;
use common\base\Model;
use Yii;
use yii\base\InvalidParamException;

/**
 * Register model
 */
class Register extends Model
{
    const EVENT_USER_REGISTER = 'mediator.user.register';

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
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->generateAuthKey();
            $user->generatePasswordResetToken();
            if ($user->save()) {
                static::getCurrentModule()->sendMessage(self::EVENT_USER_REGISTER, new UserEvent($user));

                return $user;
            }
        }
    }

    public function confirm($token)
    {
        $user = User::findByPasswordResetToken($token, User::STATUS_NEW);
        if (!$user) {
            throw new InvalidParamException('Wrong confirm token.');
        }
        $user->setActive(User::STATUS_ACTIVE);

        return $user->save(false);
    }
}
