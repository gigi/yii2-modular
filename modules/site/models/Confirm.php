<?php

namespace modules\site\models;

use common\models\UserRecord as User;
use common\base\Model;
use Yii;
use yii\base\InvalidParamException;

/**
 * Confirm model
 */
class Confirm extends Model
{
    const EVENT_USER_REGISTER = 'mediator.user.confirmed';

    public $user;
    public $token;
    public $password;
    public $passwordConfirm;

    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->user = User::findByPasswordResetToken($token, User::STATUS_NEW);
        if (!$this->user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        $this->token = $token;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'filter', 'filter' => 'trim'],
            [['password', 'passwordConfirm'], 'required'],
            ['password', 'string', 'min' => 6, 'max' => 255],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords don\'t match'],
        ];
    }

    public function confirm()
    {
        if (!$this->validate()) {
            return false;
        }
        $this->user->setPassword($this->password);
        $this->user->setActive();

        return $this->user->save();
    }
}
