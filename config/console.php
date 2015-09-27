<?php
// merge db local config with global
$db = require(__DIR__ . '/db.php');
if (file_exists(__DIR__ . '/local/db.php')) {
    $db = yii\helpers\ArrayHelper::merge(
        $db,
        require(__DIR__ . '/local/db.php')
    );
}

// merge params local config with global
$params = require(__DIR__ . '/params.php');
if (file_exists(__DIR__ . '/local/params.php')) {
    $params = yii\helpers\ArrayHelper::merge(
        $params,
        require(__DIR__ . '/local/params.php')
    );
}

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'common\commands',
    'components' => [
        'db' => $db,
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'common\components\MigrateController',
            'migrationTable' => 'migrations'
        ],
    ],
    'params' => $params,
];
