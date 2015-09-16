<?php

namespace app\common\controllers;
use app\common\BaseController;

class ErrorsController extends BaseController
{
    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }
}