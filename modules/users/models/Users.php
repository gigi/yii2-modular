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
use common\models\UserRecord;
use yii\base\InvalidParamException;

class Users extends Model
{
    public $id;
    public $password;
    public $email;
    public $status;
    public $created;
    public $updated;

    public function __construct($id = null, array $config = null)
    {
        parent::__construct($config);
        if ($id) {
            $this->id = $id;
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
}