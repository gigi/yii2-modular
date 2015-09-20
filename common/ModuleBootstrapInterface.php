<?php

namespace app\common;

/**
 * Interface ModuleBootstrapInterface
 * @package app\common
 */
interface ModuleBootstrapInterface
{
    /**
     * Bootstrap for module
     *
     * You can attach events or configure routes here
     * Will be executed on app start without creating module class instance
     *
     * @param $app object current Yii::app() instance
     * @return bool if false app\common\components\Loader stops load the app and throws ModuleBootstrapException
     */
    public static function bootstrap($app);

    /**
     * Boot order for module
     * @return int
     */
    public static function getBootOrder();
}