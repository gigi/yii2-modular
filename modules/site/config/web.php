<?php

return [
    /**
     * to use common layout use
     * 'layout' => '//main'
     */
    'routes' => [
        '' => 'site/index',
        '<action:(login|logout|register|forgotten|confirm|password-reset)>' => 'site/index/<action>',
    ],
];