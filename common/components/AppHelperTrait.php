<?php

namespace common\components;

use yii\base\Exception;
use yii\base\InvalidParamException;

/**
 * Trait to get some Yii global functionality
 * Class AppHelper
 * @package app\components
 */
trait AppHelperTrait
{
    /**
     * Returns params from config by key
     * if key == null return all params
     *
     * @param null $key
     * @return array
     * @throws Exception;
     */
    public function getParams($key = null)
    {
        $params = \Yii::$app->params;
        if ($key) {
            if (!$params[$key]) {
                throw new InvalidParamException('Param ' . $key . ' not found');
            }

            return $params[$key];
        }

        return $params;
    }

    /**
     * @return \yii\rbac\ManagerInterface
     */
    public function getAuthManager()
    {
        return \Yii::$app->getAuthManager();
    }
}