<?php

return [
    'routes' => [
        [
            'class' => 'yii\web\GroupUrlRule',
            'prefix' => 'admin/logs',
            'routePrefix' => '/logs',
            'rules' => [
                '/' => 'index/index',
            ],
        ],
    ],
    'layout' => '/backend/main'
];