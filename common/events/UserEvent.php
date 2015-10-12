<?php

namespace common\events;

use common\models\UserRecord;

/**
 * Common user events
 */
class UserEvent extends \common\base\Event
{
    public $user;

    public function __construct(UserRecord $user)
    {
        $this->user = $user;
        parent::__construct();
    }
}