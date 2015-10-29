<?php

namespace modules\admin\controllers;

use Yii;
use common\base\Controller;


/**
 * Class IndexController
 * @package app\modules\admin\controllers
 */
class NowController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        echo 'NowIndex';
    }

    public function actionTest()
    {
        echo 'NowTest';
    }
}