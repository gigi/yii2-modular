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
                                'label' => 'Create role',
                                'url' => ['/users/rbac/create-role'],
                            ],
                            [
                                'label' => 'Create permission',
                                'url' => ['/users/rbac/create-permission'],
                            ],
                            [
                                'label' => 'Edit role',
                                'url' => ['/users/rbac/edit-role'],
                                'hide' => true
                            ],
                            [
                                'label' => 'Edit permission',
                                'url' => ['/users/rbac/edit-permission'],
                                'hide' => true
                            ]
                        ]
                    ],
                ]
            ]
        ]);
    }
}