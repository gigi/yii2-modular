<?php

namespace modules\mediator\events;

use yii\base\Event;

class EmailEvent extends Event
{
    const TEMPLATE_CONFIRM = 'confirm';
    const TEMPLATE_FORGOTTEN = 'forgotten';

    public $subject;
    public $message;
    public $template;
    public $to;
    public $params = [];
}