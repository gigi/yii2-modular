<?php

namespace modules\mediator\events;

class EmailEvent extends \common\base\Event
{
    const TEMPLATE_CONFIRM = 'confirm';

    public $subject;
    public $message;
    public $template;
    public $to;
    public $params = [];
}