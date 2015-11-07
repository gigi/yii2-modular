<?php

return [
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'htmlLayout' => '@modules/emails/views/layouts/htmlMain',
            'textLayout' => '@modules/emails/views/layouts/textMain',
            'viewPath' => '@modules/emails/views/'
        ]
    ],
    'routes' => [
        [
            'class' => 'yii\web\GroupUrlRule',
            'prefix' => 'admin/emails',
            'routePrefix' => '/emails',
            'rules' => [
                '/' => 'index/index',
            ],
        ],
    ],
    'layout' => '/backend/main',
    'events' => [
        'email.send' => ['modules\emails\models\Sender', 'send']
    ]
];