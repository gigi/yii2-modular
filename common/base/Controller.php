<?php

namespace common\base;

use common\components\AppHelperTrait;
use common\components\ModuleHelperTrait;

/**
 * Class BaseController
 * @package common\controllers
 */
abstract class Controller extends \yii\web\Controller
{
    use ModuleHelperTrait;
    use AppHelperTrait;

    /**
     * @return bool
     */
    public function isGuest()
    {
        return \Yii::$app->user->isGuest;
    }

    /**
     * @return null|\yii\web\IdentityInterface
     */
    public function getUser()
    {
        return \Yii::$app->user->identity;
    }

    public function getRequest()
    {
        return \Yii::$app->getRequest();
    }

    public function isAjax()
    {
        return $this->getRequest()->isAjax;
    }
}