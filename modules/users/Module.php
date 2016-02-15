<?php

/*
 * This file is part of the Yii2-modular skeleton https://github.com/gigi/yii2-modular
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace modules\users;
use modules\users\components\AuthManager;

/**
 * General users module
 */
class Module extends \common\base\Module
{
    /**
     * @inheritdoc
     */
    public static function bootstrap($app)
    {
        $app->set('authManager', [
            'class' => AuthManager::className(),
        ]);

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
                        'label' => 'Edit',
                        'url' => ['/users/index/edit'],
                        'hide' => true
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