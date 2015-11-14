<?php

namespace common\rbac;

class UserRule extends \yii\rbac\Rule
{
    public $name = 'isUser';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return $params['user'] == $user;
    }
}