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
    private $app;
    private $config;

    /**
     * @param \yii\base\Application $app
     * @throws ModuleBootstrapException
     * @throws UnknownClassException
     */
    public function bootstrap($app)
    {
        $this->app = $app;
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
                throw new ModuleBootstrapException('Module ' . $className . ' must implement app\common\ModuleBootstrapInterface interface');
            }
            if (!$app->hasModule($module)) {
                $app->setModule($module, $className);
            }
            // add routes and events
            $this->configure($module);
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
     * @return string
     */
    private function getModulesPath()
    {
        return $this->app->basePath . DIRECTORY_SEPARATOR . 'modules';
    }

    /**
     * Default path for module routes is modules/MODULE_NAME/config/web.php
     */
    private function getConfigFilePath($moduleName)
    {
        return $this->getModulesPath() . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'web.php';
    }

    private function configure($moduleName)
    {
        $filePath = realpath($this->getConfigFilePath($moduleName));
        if ($filePath) {
            $this->config = $config = require($filePath);
        }
        if (!empty($config['routes'])) {
            $this->addRoutes($config['routes']);
        }
        if (!empty($config['events'])) {
            $this->attachEvents($config['events']);
        }
    }

    /**
     * Helper to load custom module routes if present in config/routes.php
     */
    private function addRoutes($routes)
    {
        $this->app->getUrlManager()->addRules($routes);
    }

    /**
     * Helper to load events
     */
    private function attachEvents(array $events)
    {
        foreach ($events as $event => $handler) {
            $this->app->on($event, $handler);
        }
    }
}