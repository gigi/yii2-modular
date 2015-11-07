<?php

namespace modules\emails\controllers;

use modules\emails\components\ModuleController;

class IndexController extends ModuleController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}