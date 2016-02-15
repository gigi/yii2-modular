<?php

/*
 * This file is part of the Yii2-modular skeleton https://github.com/gigi/yii2-modular
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace modules\users\components;

use modules\users\models\AuthItem;
use modules\users\models\Permission;
use modules\users\models\Role;
use yii\base\InvalidParamException;
use yii\rbac\DbManager;
use yii\db\Query;
use yii\rbac\Item;
use yii\rbac\Rule;

/**
 * Overriding DbManager to get control under items and change some methods
 * @package modules\users\components
 */
class AuthManager extends DbManager
{
    /**
     * @param $name
     * @param array $exclude items to exclude
     *
     * @return bool|AuthItem
     */
    public function getItem($name, $exclude = [])
    {
        if (empty($name)) {
            return null;
        }

        if (!empty($this->items[$name])) {
            return $this->items[$name];
        }

        $query = (new Query)
            ->from($this->itemTable)
            ->where(['name' => $name]);
        if (!empty($exclude)) {
            $query->andWhere(['!=', 'name', $exclude]);
        }
        $row = $query->one($this->db);

        if ($row === false) {
            return null;
        }

        if (!isset($row['data']) || ($data = @unserialize($row['data'])) === false) {
            $row['data'] = null;
        }

        return $this->populateItem($row);
    }

    /**
     * @inheritdoc
     */
    public function getItems($type = null, $exclude = [])
    {
        $query = (new Query)->from($this->itemTable);
        if ($type) {
            $query->where(['type' => $type]);
        }
        if (!empty($exclude)) {
            $query->andWhere(['!=', 'name', $exclude]);
        }

        $items = [];
        foreach ($query->all($this->db) as $row) {
            $items[$row['name']] = $this->populateItem($row);
        }

        return $items;
    }

    /**
     * @inheritdoc
     */
    public function getRole($name)
    {
        $item = $this->getItem($name);
        return ($item instanceOf AuthItem || $item instanceOf Item) && $item->type == Item::TYPE_ROLE ? $item : null;
    }

    /**
     * @inheritdoc
     */
    public function getPermission($name)
    {
        $item = $this->getItem($name);
        return ($item instanceOf AuthItem || $item instanceOf Item) && $item->type == Item::TYPE_PERMISSION ? $item : null;
    }

    /**
     * @inheritdoc
     */
    public function add($object)
    {
        if ($object instanceof AuthItem || $object instanceof Item) {
            return $this->addItem($object);
        } elseif ($object instanceof Rule) {
            return $this->addRule($object);
        } else {
            throw new InvalidParamException('Adding unsupported object type.');
        }
    }

    /**
     * @inheritdoc
     */
    public function remove($object)
    {
        if ($object instanceof AuthItem || $object instanceof Item) {
            return $this->removeItem($object);
        } elseif ($object instanceof Rule) {
            return $this->removeRule($object);
        } else {
            throw new InvalidParamException('Removing unsupported object type.');
        }
    }

    /**
     * @inheritdoc
     */
    public function update($name, $object)
    {
        if ($object instanceof AuthItem || $object instanceof Item) {
            return $this->updateItem($name, $object);
        } elseif ($object instanceof Rule) {
            return $this->updateRule($name, $object);
        } else {
            throw new InvalidParamException('Updating unsupported object type.');
        }
    }

    public function populateItem($row)
    {
        $class = $row['type'] == Item::TYPE_PERMISSION ? Permission::className() : Role::className();

        if (!isset($row['data']) || ($data = @unserialize($row['data'])) === false) {
            $data = null;
        }

        if (!empty($row['rule_name'])) {
            $rule = $this->getRule($row['rule_name']);
        }

        return new $class([
            'isNew' => false,
            'name' => $row['name'],
            'oldName' => $row['name'],
            'description' => $row['description'],
            'ruleName' => $row['rule_name'],
            'ruleClass' => !empty($rule) ? get_class($rule) : null,
            'data' => $data,
            'createdAt' => $row['created_at'],
            //'children' => $this->getChildren($row['name'])
        ]);
    }

    /**
     * @param AuthItem $model
     * @return bool
     */
    public function save($model)
    {
        if (!$model->validate()) {
            return false;
        }

        if (!empty($model->getRuleClass())) {
            $ruleClassName = $model->getRuleClass();
            $rule = new $ruleClassName;
            $ruleName = $rule->name;
            if (!$this->getRule($ruleName)) {
                $this->add($rule);
            }
            $model->setRuleName($ruleName);
        }

        if ($model->getIsNew()) {
            $model->getAuthManager()->add($model);
        } else {
            $model->getAuthManager()->update($model->getOldName(), $model);
        }

        try {
            $this->updateChildren($model, $model->getChildren());
        } catch (\Exception $e) {
            $model->addError('children', $e->getMessage());
            return false;
        }

        return $model;
    }

    /**
     * Removes old children, adds new children
     *
     * @param $item
     * @param $children
     */
    public function updateChildren($item, $children = [])
    {
        $this->removeChildren($item);
        if (!empty($children)) {
            foreach($children as $childName) {
                $child = $this->getItem($childName);
                $this->addChild($item, $child);
            }
        }
    }

    /**
     * @param AuthItem $model
     * @return bool
     */
    public function delete($model)
    {
        return $this->remove($model);
    }

}