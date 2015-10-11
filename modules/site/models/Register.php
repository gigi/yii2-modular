<?php

namespace modules\site\models;

use common\events\Events;
use common\events\UserRegisterEvent;
use common\models\UserRecord as User;
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
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->generateAuthKey();

            if ($user->save()) {
                Yii::$app->trigger(Events::USER_PRE_REGISTER, new UserRegisterEvent($user));
                return $user;
            }
        }

        return null;
    }
}
