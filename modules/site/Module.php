<?php
namespace app\modules\site;

use app\common\BaseModule;

/**
 * Basic site module class
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