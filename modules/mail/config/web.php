<?php

return [
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'htmlLayout' => '@modules/mail/views/layouts/htmlMain',
            'textLayout' => '@modules/mail/views/layouts/textMain',
            'viewPath' => '@modules/mail/views/'
        ]
    ],
    'events' => [
        'email.send' => ['modules\mail\models\Sender', 'send']
    ]
];