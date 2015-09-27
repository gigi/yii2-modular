<?php

namespace modules\admin\controllers;

use common\base\Controller;

use Yii;
use yii\base\Event;

/**
 * Class IndexController
 * @package app\modules\admin\controllers
 */
class IndexController extends Controller
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