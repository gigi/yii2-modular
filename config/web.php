<?php
// Main app config
return [
    'id' => 'Base',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\common\controllers',
    'bootstrap' => [
        'log',
        'app\common\components\Loader'
    ],
    'components' => [
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
            'identityClass' => 'app\common\models\User',
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
    ]
];