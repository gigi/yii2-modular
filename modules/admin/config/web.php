<?php

return [
    'routes' => [
        [
            'class' => 'yii\web\GroupUrlRule',
            'prefix' => 'admin',
            'rules' => [
                '/' => 'index/index',
                '<controller:\w+>'  => '<controller>/index',
                '<controller:\w+>/<action:\w+>'  => '<controller>/<action>'
            ],
        ],
    ]
];