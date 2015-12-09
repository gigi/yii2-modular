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

use common\base\Model;

/**
 * Auth item domain model
 *
 * @author Alexey Snigirev <gigi@ua.fm>
 */
class AuthItem extends Model
{
    /** @var \yii\db\ActiveQuery|null */
    public $items;

    /** @var \yii\db\ActiveQuery|null */
    public $item;

    public function __construct($id = null, $config = null)
    {
        parent::__construct($config);
        if (!empty($id)) {
            if ($item = AuthItemRecord::findOne(['name' => $id])) {
                $this->item = $item;
                $this->name = $item->name;
            } else {
                throw new \InvalidArgumentException;
            }
        } else {
            $this->items = AuthItemRecord::find();
        }
    }

    public function attributeLabels()
    {
        return [
            'type' => ($this->item->type == 1 ? 'Role' : 'Permission')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return clone $this->items->where([
            'type' => \yii\rbac\Role::TYPE_ROLE
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermissions()
    {
        return clone $this->items->where([
            'type' => \yii\rbac\Role::TYPE_PERMISSION
        ]);
    }
}
