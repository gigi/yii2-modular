<?php

namespace modules\mail\models;

//use common\components\Email;

class Sender extends \common\base\Model
{
    public static function send($event)
    {
        $mail = static::getCurrentModule()->mailer->compose();
        $mail->setTo($event->to);

        return $mail->send();
    }
}