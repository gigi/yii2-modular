<?php
namespace app\modules\site;

use app\common\BaseModule;

/**
 * Basic site module class
 */
class Module extends BaseModule
{
    private static $routes = [
        '' => 'site/index'
    ];

    public static function bootstrap($app)
    {
        echo 'Hello from site module bt';
        $app->getUrlManager()->addRules(self::$routes);

        // EVENTS!

        return true;
    }

    public function init()
    {
        parent::init();
        echo 'Hello from site module init';
    }


}