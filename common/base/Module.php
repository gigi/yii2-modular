<?php

namespace common\base;

use common\components\Loader;
use common\components\ModuleHelperTrait;
use \common\interfaces\ModuleBootstrapInterface;
use yii\base\Event;
use yii\helpers\ArrayHelper;

/**
 * Class BaseModule
 * @package app\common
 */
abstract class Module extends \yii\base\Module implements ModuleBootstrapInterface
{
    use ModuleHelperTrait;

    public $routes;
    public $events;
    public $bootOrder = Loader::BOOT_ORDER_DEFAULT;

    /**
     * @inheritdoc
     */
    public static function bootstrap($app)
    {
        return true;
    }

    public function init()
    {
        parent::init();
        $this->layout = 'main';
        $configPath = realpath($this->getBasePath() . DIRECTORY_SEPARATOR . 'config');
        $config = require($configPath . DIRECTORY_SEPARATOR . 'web.php');
        $localConfigPath = realpath($configPath . DIRECTORY_SEPARATOR . 'local' . DIRECTORY_SEPARATOR . 'web.php');
        if ($localConfigPath) {
            $config = ArrayHelper::merge($config, require($localConfigPath));
        }
        if ($configPath) {
            \Yii::configure($this, $config);
        }
    }

    /**
     * Wrapper for event trigger
     *
     * @param $message
     * @param Event $event
     */
    public function sendMessage($message, Event $event)
    {
        \Yii::$app->trigger($message, $event);
    }
}