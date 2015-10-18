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
    'id' => 'Base',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'common\controllers',
    'bootstrap' => [
        'debug',
        'log',
        'common\components\Loader'
    ],
    'modules' => [
        'site',
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1']
        ]
    ],
    'components' => [
        'db' => $db,
        'view' => [
            'theme' => [
                'basePath' => '@app/common/themes/basic',
                'baseUrl' => '@web/themes/basic',
                'pathMap' => [
                    '@app/views'   => '@common/themes/basic',
                    '@app/modules' => '@common/themes/basic/modules',
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\UserRecord',
            'enableAutoLogin' => true,
            'loginUrl' => '/login'
        ],
        'session' => [
            'name' => 'sid',
            'class' => 'yii\web\Session',
            'cookieParams' => [
                'lifetime' => 3600 * 24 * 10
            ],
            'timeout' => 3600 * 24 * 10,
            'useCookies' => true,
        ],
        'urlManager' => require(__DIR__ . '/urlManager.php'),
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => ''
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'errors/error',
        ],
        'controllerPath' => 'common/controllers',
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params
];
