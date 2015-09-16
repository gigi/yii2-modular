<?php

namespace app\common\components;

use yii\base\BootstrapInterface;
use app\common\exceptions\ModuleBootstrapException;
use yii\base\UnknownClassException;

/**
 * Basic Module loader class
 * @package app\common\components
 */
class Loader implements BootstrapInterface
{
    private $_app;
    private $_modulesPath;

    /**
     * @param \yii\base\Application $app
     * @throws ModuleBootstrapException
     * @throws UnknownClassException
     */
    public function bootstrap($app)
    {
        $this->_app = $app;
        $modulesPath = $this->getModulesPath();
        $modules = array_diff(scandir($modulesPath), array('..', '.'));
        $modulesOrder = [];
        foreach ($modules as $module) {
            $className = 'app\modules\\' . $module . '\Module';
            if (!class_exists($className)) {
                throw new UnknownClassException('Can\'t load module ' . $className);
            }
            $interfaces = class_implements($className);
            // since PHP 5.5
            // if (!isset($interfaces[ModuleBootstrapInterface::class])) {
            if (!isset($interfaces['app\common\ModuleBootstrapInterface'])) {
                throw new ModuleBootstrapException('Module ' . $className . ' must implement app\common\ModuleBootstrapInterface class');
            }
            if (!$app->hasModule($module)) {
                $app->setModule($module, $className);
            }
            $this->setRoutes($module);
            $modulesOrder[$className] = $className::getBootOrder();
        }
        asort($modulesOrder);

        foreach ($modulesOrder as $className => $order) {
            $className::bootstrap($app);
        }
    }

    /**
     * Returns modules path
     *
     * @param $app
     * @return string
     */
    private function getModulesPath()
    {
        return $this->_modulesPath = $this->_app->basePath . DIRECTORY_SEPARATOR . 'modules';
    }

    /**
     * Default path for module routes is modules/MODULE_NAME/config/routes.php
     */
    private function getRoutesFile($module)
    {
        return $this->_modulesPath . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routes.php';
    }

    /**
     * Helper to load custom module routes if present in config/routes.php
     */
    private function setRoutes($module)
    {
        $routesPath = $this->getRoutesFile($module);
        if (realpath($routesPath)) {
            $routes = require($routesPath);
            $this->_app->getUrlManager()->addRules($routes);
        }
    }
}