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
use modules\users\components\AuthManager;
use yii\data\ArrayDataProvider;
use yii\rbac\Rule;

/**
 * Auth item domain model
 *
 * @author Alexey Snigirev <gigi@ua.fm>
 */
abstract class AuthItem extends Model
{
    /** @var AuthManager  */
    protected $authManager;

    /** @var string $id equal to $name to update or create new item */
    private $id;
    private $name;
    private $description;
    private $createdAt;
    private $updatedAt;
    private $ruleClass;
    private $ruleName;
    private $children;
    private $data;
    private $isNew;

    public function __construct($config = null)
    {
        parent::__construct($config);

        // TODO: move to manager, leave just entity (...with validation)
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
     * Returns item type
     * ROLE = 1
     * PERMISSION = 2
     *
     * @return integer
     */
    abstract public function getType();

    /**
     * List of possible children
     * For roles - all roles (except current role) and all permissions
     * For permissions - all permissions except current permission
     *
     * @return array
     */
    abstract public function getPossibleChildrenArray();

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'uniqueItemValidator'],
            ['name', 'string', 'length' => [3, 24]],
            [['description', 'ruleName', 'children', 'createdAt', 'updatedAt'], 'safe'],
            [['description', 'ruleName', 'data'], 'default', 'value' => null],
            ['ruleClass', 'classValidator']
        ];
    }

    /**
     * Validates item by name
     */
    public function uniqueItemValidator()
    {
        $exclude = null;
        if (!$this->getIsNew()) {
            $exclude = $this->getId();
        }
        if ($this->getAuthManager()->getItem($this->getName(), $exclude)) {
            $this->addError('name', 'This name already used');
        }
    }

    /**
     * Checks for valid rule class
     * @param string $name attribute name
     *
     */
    public function classValidator($name)
    {
        $className = $this->$name;
        if (!class_exists($className)) {
            $this->addError('ruleClass', 'Class doesn\'t exists');
        } else {
            $class = new $className;
            if (!($class instanceof Rule)) {
                $this->addError('ruleClass', 'Class should be an instance of \yii\rbac\Rule');
            }
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
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Check is new record
     *
     * @return bool
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * @param bool $isNew
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $created
     */
    public function setCreatedAt($created)
    {
        $this->createdAt = $created;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $updated
     */
    public function setUpdatedAt($updated)
    {
        $this->updatedAt = $updated;
    }

    /**
     * @return mixed
     */
    public function getRuleClass()
    {
        return $this->ruleClass;
    }

    /**
     * @param $class
     */
    public function setRuleClass($class)
    {
        $this->ruleClass = $class;
    }

    /**
     * @return mixed
     */
    public function getRuleName()
    {
        return $this->ruleName;
    }

    /**
     * @param string $name
     */
    public function setRuleName($name)
    {
        $this->ruleName = $name;
    }

    /**
     * @return AuthManager
     */
    public function getAuthManager()
    {
        return $this->authManager;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
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
                    'id' => $model->getName(),
                    'type' => $model->getType()
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
}
