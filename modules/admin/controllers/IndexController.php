<?php

namespace app\modules\admin\controllers;

use app\common\BaseController;

use Yii;
use yii\base\Event;

/**
 * Class IndexController
 * @package app\modules\admin\controllers
 */
class IndexController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        \Yii::$app->trigger('USER_REGISTERED', new Event(['sender' => ['abc']]));

        return $this->render('index');
    }
}