<?php

namespace modules\mediator\events;

class EmailEvent extends \common\base\Event
{
    const TYPE_TEMPLATE = 'template';
    const TYPE_RAW      = 'raw';

    public $message;
    public $type = self::TYPE_RAW;
    public $to;
    public $params = [];
}