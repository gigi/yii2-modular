<?php

namespace modules\admin\models;

use common\base\Model;
use common\models\UserRecord;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\User;

class Users extends Model
{
    public $password;
    public $email;
    public $status;

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
            [['email', 'password', 'status'], 'safe']
        ];
    }

    /**
     * @param null $status
     * @return array
     * @throws Exception wrong status
     */
    public function getStatuses($status = null)
    {
        $statuses = [
            UserRecord::STATUS_DELETED => [
                'label' => 'Deleted',
                'type'  => 'default',
            ],
            UserRecord::STATUS_BANNED => [
                'label' => 'Banned',
                'type'  => 'danger',
            ],
            UserRecord::STATUS_NEW => [
                'label' => 'New',
                'type'  => 'info',
            ],
            UserRecord::STATUS_ACTIVE => [
                'label' => 'Active',
                'type'  => 'success',
            ],
        ];

        if ($status !== null && !isset($statuses[$status])) {
            throw new Exception('Wrong status ' . $status);
        }

        return $statuses[$status];
    }

    public static function getUser($id)
    {
        $model = new static;
        $model->load(['Users' => UserRecord::findById($id)->toArray()]);

        return $model;
    }

    /**
     * Returns Active data provider for grid
     * @return ActiveDataProvider
     */
    public function getUsersProvider()
    {
        return new ActiveDataProvider([
            'query' => UserRecord::getUsers()
        ]);
    }
}