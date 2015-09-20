<?php

return [
    'events' => [
        'USER_REGISTERED' => ['app\modules\admin\models\Sender', 'emailHandler']
    ],
    'routes' => [
        'admin' => 'admin/index'
    ]
];