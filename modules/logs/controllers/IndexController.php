<?php

namespace modules\logs\controllers;

use modules\logs\components\ModuleController;

class IndexController extends ModuleController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}