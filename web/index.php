<?php
/**
 * Hello world!
 */
if (isset($_SERVER['YII_ENV']) && $_SERVER['YII_ENV'] === 'DEV') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
}

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../config/bootstrap.php');

// Merge global and local configs
$config = require(__DIR__ . '/../config/web.php');
$localConfigPath = __DIR__ . '/../config/local/web.php';

if (file_exists($localConfigPath)) {
    $localConfig = require($localConfigPath);
    $config = \yii\helpers\BaseArrayHelper::merge($config, $localConfig);
}

// Classes configuration (via Dependency Injection)
// http://www.yiiframework.com/doc-2.0/guide-concept-di-container.html
require(__DIR__ . '/../config/di.php');

(new yii\web\Application($config))->run();