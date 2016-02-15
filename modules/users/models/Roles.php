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

use yii\rbac\Item;

class Roles extends AuthItem
{
    /**
     * @return int
     */
    public function getType()
    {
        return Item::TYPE_ROLE;
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'Roles';
    }

    /**
     * @inheritdoc
     */
    public function getUniqueId()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function getModels()
    {
        return $this->getAuthManager()->getRoles();
    }

    /**
     * @inheritdoc
     */
    public function getPossibleChildrenArray()
    {
        return $this->getAuthManager()->getItems(null, $this->getName());
    }
}