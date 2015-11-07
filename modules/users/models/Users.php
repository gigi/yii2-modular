<?php

namespace modules\users\models;

use common\base\Model;
use common\models\UserRecord;
use common\exceptions\UserNotFoundException;
use yii\base\InvalidParamException;

class Users extends Model
{
    public $id;
    public $password;
    public $email;
    public $status;
    public $created;
    public $updated;
    // common/models/UserRecord
    public $user;
    // common/models/UserRecord::find()
    public $users;

    /**
     * @inheritdoc
     */
    public function __construct($id = null, $config = null)
    {
        parent::__construct($config);
        if ($id) {
            // one user
            if ($user = UserRecord::findById($id)) {
                $this->user = $user;
            } else {
                throw new UserNotFoundException;
            }
        } else {
            // all users
            $this->users = UserRecord::find();
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['status', 'default', 'value' => UserRecord::STATUS_NEW],
            [
                'status',
                'in',
                'range' => [
                    UserRecord::STATUS_BANNED,
                    UserRecord::STATUS_DELETED,
                    UserRecord::STATUS_ACTIVE,
                    UserRecord::STATUS_NEW
                ]
            ],
            [['email', 'created', 'status'], 'safe']
        ];
    }

    /**
     * @param null $status
     * @return array
     * @throws InvalidParamException wrong status
     */
    public static function getStatuses($status = null)
    {
        $statuses = [
            UserRecord::STATUS_DELETED => [
                'label' => 'Deleted',
                'type' => 'default',
            ],
            UserRecord::STATUS_BANNED => [
                'label' => 'Banned',
                'type' => 'danger',
            ],
            UserRecord::STATUS_NEW => [
                'label' => 'New',
                'type' => 'info',
            ],
            UserRecord::STATUS_ACTIVE => [
                'label' => 'Active',
                'type' => 'success',
            ],
        ];

        if ($status !== null && !isset($statuses[$status])) {
            throw new InvalidParamException('Wrong status ' . $status);
        } elseif ($status !== null) {
            return $statuses[$status];
        }

        return $statuses;
    }

    /**
     * @return null|static
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->password) {
            $this->user->setScenario('passwordUpdate');
            $this->user->password = $this->password;
        } else {
            $this->user->setScenario('update');
        }

        $this->user->load(['UserRecord' => $this->getAttributes()]);

        return $this->user->save();
    }

    public function delete()
    {
        $this->user->status = UserRecord::STATUS_DELETED;

        return $this->user->save();
    }
}