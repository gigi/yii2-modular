<?php

namespace modules\mediator\events;

use common\base\Event;

class LogEvent extends Event
{
    public $category;
    public $action;
    public $sender;
    public $reference;
    public $user;
    public $ip;
    public $params = [];
}