<?php

namespace common\rbac;

class UserRule extends \yii\rbac\Rule
{
    /**
     * @inheritdoc
     */
    public $name = 'isUser';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return $user == $params;
    }
}