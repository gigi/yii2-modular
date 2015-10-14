<?php

namespace common\components;

use yii\base\InvalidValueException;

/**
 * Trait to handle some necessary module methods from inner classes
 * @package common\components
 */
trait ModuleHelperTrait
{
    /**
     * Returns current module instance by class namespace
     * Uses Yii lazy loading mechanism
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
}