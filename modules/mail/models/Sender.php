<?php

namespace modules\mail\models;

//use common\components\Email;

class Sender extends \common\base\Model
{

    public static function send($event)
    {
        $mail = static::getCurrentModule()->mailer->compose($event->template, $event->params);
        $mail->setTo($event->to);
        $mail->setSubject('Confirm registration');

        return $mail->send();
    }
}