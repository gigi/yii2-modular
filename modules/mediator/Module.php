<?php

namespace modules\mediator;

use common\base\Event;

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
    /*==========================================*/
    public function sendConfirmEmail($event)
    {
        $message = \Yii::$app->mailer->compose();
        $message->setTo($event->user->email);
        \Yii::$app->trigger('email.send', new Event(['sender' => $message]));
    }
}