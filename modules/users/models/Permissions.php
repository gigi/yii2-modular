<?php

/*
 * This file is part of the Yii2-modular skeleton https://github.com/gigi/yii2-modular
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace modules\users\models;

use \yii\rbac\Item;

class Permissions extends AuthItem
{
    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Item::TYPE_PERMISSION;
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'Permissions';
    }

    /**
     * @inheritdoc
     */
    public function getUniqueId()
    {
        return 'permissions';
    }

    /**
     * TODO: move to AuthManager
     * @inheritdoc
     */
    public function getModels()
    {
        return $this->getAuthManager()->getPermissions();
    }

    /**
     * TODO: move to AuthManager
     * @inheritdoc
     */
    public function getPossibleChildrenArray()
    {
        $items = $this->getAuthManager()->getItems($this->getType(), $this->getName());

        return $items;
    }
}