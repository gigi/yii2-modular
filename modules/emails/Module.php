<?php

namespace modules\emails;

/**
 * Email module class
 */
class Module extends \common\base\Module
{
    public static function bootstrap($app)
    {
        static::registerMenu('admin', [
            [
                'label' => '<i class="nav-list__item-icon icon icon-mail4"></i>Emails',
                'url' => ['/emails/index/index']
            ]
        ]);
    }
}