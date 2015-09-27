<?php

return [
    'events' => [
        'USER_REGISTERED' => ['modules\admin\models\Sender', 'emailHandler']
    ],
    'routes' => [
        'admin' => 'admin/index'
    ]
];