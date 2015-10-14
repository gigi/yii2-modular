<?php

namespace modules\mediator\events;

class LogEvent extends \common\base\Event
{
    public $category;
    public $action;
    public $sender;
    public $reference;
    public $user;
    public $ip;
    public $params = [];
}