<?php

namespace app\modules\admin\models;

use app\common\BaseModel;

class Sender extends BaseModel {

    public function emailHandler($event)
    {
        var_dump($event->sender);
    }
}