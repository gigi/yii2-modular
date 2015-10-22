<?php

namespace modules\site\components;

use common\base\Controller;
use Yii;

/**
 * Class IndexController
 * @package app\modules\site\controllers
 */
class ModuleController extends Controller
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