<?php

namespace app\modules\admin\controllers;

use app\common\BaseController;

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
        return $this->render('index');
    }
}