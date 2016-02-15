<?php

namespace common\components;

use common\base\Event;
use yii\base\InvalidValueException;

/**
 * Trait to handle some necessary methods inside module's classes
 * @package common\components
 */
trait ModuleHelperTrait
{
    /**
     * Returns current module instance by class namespace (just one level for now...)
     * Uses Yii lazy loading mechanism
     *
     * @return null|\common\base\Module
     */
    public static function getCurrentModule()
    {
        $class = get_called_class();
        $parts = explode("\\", $class, 3);
        if (!isset($parts[0]) || $parts[0] !== 'modules' || !isset($parts[1])) {
            throw new InvalidValueException('Invalid namespace ' . $class);
        }

        return \Yii::$app->getModule($parts[1]);
    }

    /**
     * Register menu items
     *
     * @param $key
     * @param $items
     */
    public static function registerMenu($key, $items)
    {
        \Yii::$app->menu->add($key, $items);
    }

    public function publish(Event $message)
    {
        //TODO: event handler..
    }
}