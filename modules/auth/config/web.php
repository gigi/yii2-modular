<?php

return [
    'routes' => [
        '<a:(login|logout|register|forgotten|confirm|password-reset)>' => 'auth/index/<a>',
    ],
    'bootOrder' => 10
];