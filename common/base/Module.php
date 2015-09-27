<?php

namespace common\base;

use \common\interfaces\ModuleBootstrapInterface;

/**
 * Class BaseModule
 * @package app\common
 */
abstract class Module extends \yii\base\Module implements ModuleBootstrapInterface
{
    public $routes;
    public $events;

    /**
     * @inheritdoc
     */
    public static function bootstrap($app)
    {
        return true;
    }

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