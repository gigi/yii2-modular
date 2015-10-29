<?php

namespace common\base;

/**
 * Class BaseController
 * @package common\controllers
 */
abstract class Controller extends \yii\web\Controller
{
    public function isGuest()
    {
        return \Yii::$app->user->isGuest;
    }

    public function getUser()
    {
        return \Yii::$app->user->identity;
    }
}