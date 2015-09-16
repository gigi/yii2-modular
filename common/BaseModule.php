<?php

namespace app\common;

use \yii\base\Module;

/**
 * Class BaseModule
 * @package app\common
 */
abstract class BaseModule extends Module implements ModuleBootstrapInterface
{
    /**
     * Boot order is 1000 by default
     * lower bootOrder boots first
     * You can override the return value in the Module class
     *
     * @return int
     */
    public static function getBootOrder()
    {
        return 1000;
    }
}