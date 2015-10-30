<?php

namespace modules\admin\controllers;

use Yii;
use modules\admin\components\ModuleController;

/**
 * Class IndexController
 * @package app\modules\admin\controllers
 */
class IndexController extends ModuleController
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