<?php

return [
    /**
     * to use common layout use
     * 'layout' => '//main'
     */
    'routes' => [
        '' => 'site/index',
        '<action:\w+>' => 'site/index/<action>'
    ],
    'layout' => '/frontend/main'
];