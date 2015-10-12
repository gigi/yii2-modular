<?php

namespace modules\mail\models;

//use common\components\Email;

class Sender extends \common\base\Model
{
    /**
     * @param Email $message
     */
    public function send($event)
    {
       // $mail = new Email($message);
        $event->sender->send();
    }
}