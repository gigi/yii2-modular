<?php

namespace common\base;

use common\components\ModuleHelperTrait;

/**
 * Class BaseController
 * @package common\controllers
 */
abstract class Controller extends \yii\web\Controller
{
    use ModuleHelperTrait;

    public function isGuest()
    {
        return \Yii::$app->user->isGuest;
    }

    public function getUser()
    {
        return \Yii::$app->user->identity;
    }
}