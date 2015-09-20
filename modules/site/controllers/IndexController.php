<?php

namespace app\modules\site\controllers;

use app\common\BaseController;

/**
 * Class IndexController
 * @package app\modules\site\controllers
 */
class IndexController extends BaseController
{
    public function init()
    {
        
    }
    /**
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }
}