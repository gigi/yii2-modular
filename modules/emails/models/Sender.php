<?php

namespace modules\emails\models;

//use common\components\Email;

class Sender extends \common\base\Model
{
    public static function send($event)
    {
        $template = null;
        if ($event->template) {
            $template = 'templates' . DIRECTORY_SEPARATOR . $event->template;
        }
        $mail = static::getCurrentModule()->mailer->compose($template, $event->params);
        $mail->setTo($event->to);
        $mail->setSubject('Confirm registration');

        return $mail->send();
    }
}