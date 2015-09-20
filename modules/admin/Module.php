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
        return true;
    }

    public function init()
    {
        parent::init();
    }
}