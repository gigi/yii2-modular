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
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\rbac\Item;
use yii\rbac\Permission;
use yii\rbac\Role;

/**
 * Auth item domain model
 *
 * @author Alexey Snigirev <gigi@ua.fm>
 */
abstract class AuthItem extends Model
{
    protected $authManager;

    private $name;
    private $description;
    private $createdAt;

    public function __construct($id = null, $config = null)
    {
        parent::__construct($config);
        $this->authManager = \Yii::$app->authManager;
    }

    /**
     * Label for type key
     *
     * @return string
     */
    abstract public function getLabel();

    /**
     * @return array
     */
    abstract public function getModels();

    /**
     * Returns string id to use in pagination and sorting links
     *
     * @return string
     */
    abstract public function getUniqueId();

    /**
     * Creates RBAC item
     * @param $name
     * @return Role|Permission
     */
    abstract public function createItem($name);

    /**
     * Returns items by name
     *
     * @param $name
     * @return Role|Permission
     */
    abstract public function findByName($name);

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->createdAt;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'uniqueItem'],
            ['name', 'string', 'length' => [3, 24]]
        ];
    }

    public function uniqueItem($name, $params)
    {
        $result = (new Query())
            ->from($this->getAuthManager()->itemTable)
            ->where([
                'name' => $this->name
            ])
            ->one();

        if ($result) {
            $this->addError('name', 'This name already used');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type' => $this->getLabel()
        ];
    }

    /**
     * @return \yii\rbac\ManagerInterface
     */
    public function getAuthManager()
    {
        return $this->authManager;
    }

    /**
     * DataProvider to use in grids
     *
     * @return ArrayDataProvider
     */
    public function getDataProvider()
    {
        $dataProvider = new ArrayDataProvider([
            'id' => $this->getUniqueId(),
            'allModels' => array_values($this->getModels()),
            'key' => function ($model) {
                return [
                    'id' => $model->name,
                    'type' => $model->type
                ];
            },
            'sort' => [
                'defaultOrder' => [
                    'createdAt' => SORT_DESC
                ],
                'attributes' => ['name', 'createdAt'],
            ],
            'pagination' => [
                'pageSize' => $this->getParams('pageSize'),
            ]
        ]);

        return $dataProvider;
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $item = $this->createItem($this->getName());
        $item->description = $this->getDescription();

        return $this->getAuthManager()->add($item);
    }

    /**
     * Populates item to cureent model
     *
     * @param $item
     */
    public function populate($item)
    {
        $this->setAttributes((array)$item);
    }

    /**
     * @param $name
     * @return null|\yii\rbac\Role
     */
    public function loadByName($name)
    {
        $item = $this->findByName($name);
        if (!$item) {
            return null;
        }
        $this->populate($item);

        return true;
    }
}
