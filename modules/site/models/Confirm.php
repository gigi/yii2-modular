<?php

namespace modules\site\models;

use common\events\UserEvent;
use common\models\UserRecord as User;
use common\base\Model;
use Yii;
use yii\base\InvalidParamException;

/**
 * Confirm model
 */
class Confirm extends Model
{
    const EVENT_USER_CONFIRMED = 'mediator.user.confirmed';
    const EVENT_USER_PASSWORD_RESTORED = 'mediator.user.password.restored';

    const SCENARIO_PASSWORD_RESET = 'passwordReset';

    public $user;
    public $token;
    public $password;
    public $passwordConfirm;

    /**
     * @param array $token
     * @param array $config
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        parent::__construct($config);
        $this->user = User::findByPasswordResetToken($token, $this->isNewUserScenario() ? User::STATUS_NEW : User::STATUS_ACTIVE);
        if (!$this->user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        $this->token = $token;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PASSWORD_RESET] = ['password', 'passwordConfirm'];

        return $scenarios;
    }

    private function isNewUserScenario()
    {
        return $this->getScenario() != self::SCENARIO_PASSWORD_RESET;
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
        $this->user->removePasswordResetToken();

        if ($this->isNewUserScenario()) {
            $this->user->setActive();
            $action = self::EVENT_USER_CONFIRMED;
        } else {
            $action = self::EVENT_USER_PASSWORD_RESTORED;
        }
        static::getCurrentModule()->sendMessage($action, new UserEvent($this->user));

        return $this->user->save();
    }
}
