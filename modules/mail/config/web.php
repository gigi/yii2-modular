<?php

return [
    'events' => [
        common\events\Events::USER_PRE_REGISTER => ['modules\mail\models\Sender', 'sendConfirmEmail']
    ]
];