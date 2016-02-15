<?php

/*
 * This file is part of the Yii2-modular skeleton https://github.com/gigi/yii2-modular
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace modules\users\services;

use common\exceptions\UserNotFoundException;
use \common\models\UserRecord;
use \modules\users\models\Users as UserModel;
use \yii\base\Object;

/**
 * Try to make services instead of God model...
 * @package modules\users\services
 */
class Users extends Object {

    /** @var  \modules\users\models\Users */
    private $user;

    /** @var  \common\models\UserRecord */
    private $userRecord;

    public static function findAllQuery()
    {
        return UserRecord::find();
    }

    public static function getStatuses($status = null)
    {
        return UserModel::getStatuses($status);
    }

    public function findById($id)
    {
        $this->userRecord = UserRecord::findById($id);
        if (!$this->userRecord) {
            throw new UserNotFoundException;
        }

        $this->user = new UserModel($id);
        $this->user->load(['Users' => $this->userRecord->toArray()]);

        return $this->user;
    }

    /**
     * @param $data array Yii post or get request
     * @return bool
     */
    public function setUserParams(array $data)
    {
        return $this->user->load($data);
    }

    /**
     * Saves user's data
     *
     * @return bool true on success
     */
    public function saveUser()
    {
        if ($this->user->password) {
            $this->userRecord->setScenario('passwordUpdate');
            $this->userRecord->password = $this->user->password;
        } else {
            $this->userRecord->setScenario('update');
            $this->userRecord->setAttributes($this->user->toArray());
        }

        return $this->userRecord->save();
    }

    public function deleteUser()
    {
        $this->userRecord->setScenario('update');
        $this->userRecord->status = UserRecord::STATUS_DELETED;

        return $this->userRecord->save();
    }

    public function getUserModel()
    {
        return $this->user;
    }
}