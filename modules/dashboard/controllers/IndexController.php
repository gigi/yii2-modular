<?php

namespace modules\dashboard\controllers;

use modules\dashboard\components\ModuleController;

class IndexController extends ModuleController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}