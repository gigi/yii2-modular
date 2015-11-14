<?php

namespace modules\users;

/**
 * General users module
 */
class Module extends \common\base\Module
{
    public static function bootstrap($app)
    {
        static::registerMenu('admin', [
            [
                'label' => '<i class="nav-list__item-icon icon icon-users"></i>Users',
                'url' => ['/users/index/index'],
                'items' => [
                    [
                        'label' => 'Create',
                        'url' => ['/users/index/create']
                    ],
                    [
                        'label' => 'Rbac',
                        'url' => ['/users/rbac/index'],
                        'items' => [
                            [
                                'label' => 'Roles',
                                'url' => ['/users/rbac/roles'],
                            ]
                        ]
                    ],
                ]
            ]
        ]);
    }
}