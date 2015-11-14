<?php

namespace modules\auth\models;

use common\events\UserEvent;
use common\models\UserRecord as User;
use yii\base\Exception;
use common\base\Model;

class PasswordReset extends Model
{
    const EVENT_USER_PASSWORD_RESET = 'mediator.user.password.reset';

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
            [
                'email',
                'exist',
                'targetClass' => '\common\models\UserRecord',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    public function resetPassword()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findByEmail($this->email);
        if (!$user) {
            throw new Exception('Email not found');
        }
        $user->generatePasswordResetToken();
        static::getCurrentModule()->sendMessage(self::EVENT_USER_PASSWORD_RESET, new UserEvent($user));

        return $user->save();
    }
}