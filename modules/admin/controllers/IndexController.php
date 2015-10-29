<?php

namespace modules\admin\controllers;

use Yii;
use common\base\Controller;


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
        return $this->render('index');
    }

    public function actionTest()
    {
        echo 'Test';
    }
}