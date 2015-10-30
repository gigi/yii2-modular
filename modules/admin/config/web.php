<?php

return [
    'routes' => [
        [
            'class' => 'yii\web\GroupUrlRule',
            'prefix' => 'admin',
            'rules' => [
                '/' => 'index/index',
                '<controller:\w+>'  => '<controller>/index',
                '<controller:\w+>/<id:\d+>'=>'<controller>/edit',
                '<controller:\w+>/<id:\d+>/<action:\w+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'  => '<controller>/<action>',
            ],
        ],
    ]
];