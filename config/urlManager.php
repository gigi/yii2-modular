<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        'rbac/<controller>/<action>' => 'rbac/<controller>/<action>'
    ],
];
