<?php

namespace modules\users\models;

class Permissions extends AuthItem
{
    /**
     * @param $name
     * @return null|\yii\rbac\Role
     */
    public function findByName($name)
    {
        return $this->getAuthManager()->getPermission($name);
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
     * @inheritdoc
     */
    public function getModels()
    {
        return $this->getAuthManager()->getPermissions();
    }

    /**
     * @inheritdoc
     */
    public function createItem($name)
    {
        return $this->getAuthManager()->createPermission($name);
    }
}