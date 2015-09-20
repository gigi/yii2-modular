<?php

namespace app\common;

use \yii\base\Module;

/**
 * Class BaseModule
 * @package app\common
 */
abstract class BaseModule extends Module implements ModuleBootstrapInterface
{
    public $routes;
    public $events;

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

    public function init()
    {
        parent::init();
        $this->layout = 'main';
        $configPath = realpath($this->getBasePath() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'web.php');
        if ($configPath) {
            \Yii::configure($this, require($configPath));
        }
    }
}