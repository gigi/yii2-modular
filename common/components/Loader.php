<?php

namespace common\components;

use common\exceptions\ModuleUndefinedClassException;
use \yii\base\BootstrapInterface;
use \common\exceptions\ModuleBootstrapException;

/**
 * Basic Module loader class
 * @package app\common\components
 */
class Loader implements BootstrapInterface
{
    /**
     * Default boot order
     * To override add 'bootOrder' => VALUE param to config/web.php
     * Lower value loads first
     */
    const BOOT_ORDER_DEFAULT = 1000;

    /**
     * @var $app object current Yii instance
     */
    private $app;

    /**
     * @param \yii\base\Application $app
     * @throws ModuleBootstrapException
     * @throws ModuleUndefinedClassException
     */
    public function bootstrap($app)
    {
        $this->app = $app;
        $modules = array_diff(scandir($this->getModulesPath()), array('..', '.'));
        $modulesOrder = [];
        foreach ($modules as $module) {
            $className = 'modules\\' . $module . '\Module';
            if (!class_exists($className)) {
                throw new ModuleUndefinedClassException('Can\'t load module ' . $className);
            }
            $interfaces = class_implements($className);
            // since PHP 5.5
            // if (!isset($interfaces[ModuleBootstrapInterface::class])) {
            if (!isset($interfaces['common\interfaces\ModuleBootstrapInterface'])) {
                throw new ModuleBootstrapException('Module ' . $className . ' must implement common\ModuleBootstrapInterface interface');
            }
            if (!$app->hasModule($module)) {
                $app->setModule($module, $className);
            }
            // configure some properties
            $config = $this->getConfig($module);
            $this->configure($config);
            $modulesOrder[$className] = isset($config['bootOrder']) ? (int)$config['bootOrder'] : self::BOOT_ORDER_DEFAULT;
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
     * Default path for module config is modules/MODULE_NAME/config/web.php
     *
     * @param string $moduleName
     * @return string
     */
    private function getConfigFilePath($moduleName)
    {
        return $this->getModulesPath() . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'web.php';
    }

    /**
     * Returns config for module
     *
     * @param $moduleName
     * @return array
     */
    public function getConfig($moduleName)
    {
        $filePath = realpath($this->getConfigFilePath($moduleName));
        if (!$filePath) {
            return [];
        }

        return require($filePath);
    }

    /**
     * Configure module
     * Adds routes and attach events if present
     *
     * @param string $config
     */
    private function configure($config)
    {
        if (!empty($config['routes'])) {
            $this->addRoutes($config['routes']);
        }
        if (!empty($config['events'])) {
            $this->attachEvents($config['events']);
        }
    }

    /**
     * Helper to add global app routes
     *
     * @param array $routes
     */
    private function addRoutes(array $routes)
    {
        $this->app->getUrlManager()->addRules($routes);
    }

    /**
     * Helper to attach global app events
     *
     * @param array $events
     */
    private function attachEvents(array $events)
    {
        foreach ($events as $event => $handler) {
            $this->app->on($event, $handler);
        }
    }
}
