<?php

namespace modules\logs;

/**
 * App-level log module
 */
class Module extends \common\base\Module
{
    public static function bootstrap($app)
    {
        static::registerMenu('admin', [
            [
                'label' => '<i class="nav-list__item-icon icon icon-books"></i>Logs',
                'url' => ['/logs/index/index']
            ]
        ]);
    }
}