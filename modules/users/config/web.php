<?php

return [
    'layout' => '/backend/main',
    'routes' => [
        [
            'class' => 'yii\web\GroupUrlRule',
            'prefix' => 'admin/users',
            'routePrefix' => '/users',
            'rules' => [
                '/' => 'index/index',
                '<id:\d+>'=>'index/edit',
                '<id:\d+>/<action:(delete)>'=>'index/<action>',
                '<action:\w+>'=>'index/<action>',
//                '<controller:\w+>'=>'<controller>/index',
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ],
    ]
];