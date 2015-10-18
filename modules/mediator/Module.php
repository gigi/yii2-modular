<?php

namespace modules\mediator;

use modules\mediator\events\EmailEvent;
use yii\helpers\Url;

/**
 * Module implements the Mediator pattern
 * https://en.wikipedia.org/wiki/Mediator_pattern
 * https://sourcemaking.com/design_patterns/mediator)
 *
 * Used for non-direct modules communication
 * Events can be described at config/events.php
 */
class Module extends \common\base\Module
{
    const EVENT_SEND_MESSAGE = 'email.send';

    public static function sendConfirmEmail($userEvent)
    {
        $event = new EmailEvent();
        $event->template = EmailEvent::TEMPLATE_CONFIRM;
        $event->params['link'] = Url::to(['/site/index/confirm', 'token' => $userEvent->user->password_reset_token], true);
        $event->to = $userEvent->user->email;
        static::getCurrentModule()->sendMessage(self::EVENT_SEND_MESSAGE, $event);
    }
}