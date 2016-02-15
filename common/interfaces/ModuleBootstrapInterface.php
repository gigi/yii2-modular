<?php

namespace common\interfaces;
use yii\web\Application;

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
     * @param Application $app object current Yii::app() instance
     *
     */
    public static function bootstrap($app);
}