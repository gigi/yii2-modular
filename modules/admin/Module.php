<?php

namespace app\modules\admin;

use app\common\BaseModule;

/**
 * General admin module
 */
class Module extends BaseModule
{
    public static function bootstrap($app)
    {
        echo 'Hello from admin module bt';
        return true;
    }

    public function init()
    {
        parent::init();
    }
}