<?php

namespace modules\dashboard;

/**
 * Dashboard module class
 */
class Module extends \common\base\Module
{
    public static function bootstrap($app)
    {
        static::registerMenu('admin', [
            [
                'label' => '<i class="nav-list__item-icon icon icon-home"></i>Home',
                'url' => ['/dashboard/index/index']
            ]
        ]);
    }
}