<?php

return [
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true
        ]
    ],
    'events' => [
        'email.send' => ['modules\mail\models\Sender', 'send']
    ]
];