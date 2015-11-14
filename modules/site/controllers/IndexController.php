<?php

namespace modules\site\controllers;

use modules\site\components\ModuleController;

class IndexController extends ModuleController
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionContact()
    {
        return 'Contact';
    }
}