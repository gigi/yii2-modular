<?php

namespace modules\mediator;

use modules\mediator\events\EmailEvent;

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

    public function sendConfirmEmail($userEvent)
    {
        $event = new EmailEvent();
        $event->to = $userEvent->user->email;
        static::sendMessage(self::EVENT_SEND_MESSAGE, $event);
    }
}