<?php

return [
    /**
     * to use common layout use
     * 'layout' => '//main'
     */
    'routes' => [
        '' => 'site/index',
        '<action:(login|logout|register|forgotten|confirm)>' => 'site/index/<action>',
    ],
];