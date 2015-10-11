<?php

namespace modules\mail\models;

use common\components\Email;
use common\events\UserRegisterEvent;

class Sender extends \common\base\Model
{
    public function sendConfirmEmail(UserRegisterEvent $event)
    {
        $mail = new Email();
        $mail->setTo($event->user->email);
        $mail->send();
    }
}