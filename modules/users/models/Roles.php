<?php

namespace modules\users\models;

class Roles extends AuthItem
{
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
    public function findByName($name)
    {
        return $item = $this->getAuthManager()->getRole($name);
    }

    /**
     * @inheritdoc
     */
    public function createItem($name)
    {
        return $this->getAuthManager()->createRole($name);
    }
}