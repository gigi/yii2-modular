<?php

namespace common\events;

use common\models\UserRecord;

class UserRegisterEvent extends \common\base\Event
{
    public $user;

    public function __construct(UserRecord $user)
    {
       $this->user = $user;
    }
}