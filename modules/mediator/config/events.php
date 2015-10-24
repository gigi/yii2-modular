<?php

return [
    'mediator.user.register' => ['modules\mediator\Module', 'sendConfirmEmail'],
    'mediator.user.password.reset' => ['modules\mediator\Module', 'sendForgottenEmail']
];