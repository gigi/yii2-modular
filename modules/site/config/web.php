<?php

return [
    /**
     * to use common layout use
     * 'layout' => '//main'
     */
    'routes' => [
        '' => 'site/index',
        '<action:(login|logout|register|forgotten)>' => 'site/index/<action>',
    ],
];