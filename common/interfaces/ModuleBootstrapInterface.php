<?php

namespace common\interfaces;

/**
 * Interface ModuleBootstrapInterface
 * @package common
 */
interface ModuleBootstrapInterface
{
    /**
     * Bootstrap for module
     *
     * You can attach events or configure routes here
     * Will be executed on app start without creating module class instance
     *
     * @param object $app object current Yii::app() instance
     *
     */
    public static function bootstrap($app);
}