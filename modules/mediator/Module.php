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

    /**
     * Send email event trigger
     * @param $template
     * @param $email
     * @param array $params
     */
    public static function sendEmail($template, $email, $params = [])
    {
        $event = new EmailEvent();
        $event->template = $template;
        $event->to = $email;
        $event->params = $params;
        static::getCurrentModule()->sendMessage(self::EVENT_SEND_MESSAGE, $event);
    }

    /**
     * Confirm email message
     * @param $userEvent
     */
    public static function sendConfirmEmail($userEvent)
    {
        $params['link'] = Url::to(['/site/index/confirm', 'token' => $userEvent->user->password_reset_token], true);
        static::sendEmail(EmailEvent::TEMPLATE_CONFIRM, $userEvent->user->email, $params);
    }

    /**
     * Forgotten password email message
     * @param $userEvent
     */
    public static function sendForgottenEmail($userEvent)
    {
        $params['link'] = Url::to(['/site/index/password-reset', 'token' => $userEvent->user->password_reset_token], true);
        static::sendEmail(EmailEvent::TEMPLATE_FORGOTTEN, $userEvent->user->email, $params);
    }
}