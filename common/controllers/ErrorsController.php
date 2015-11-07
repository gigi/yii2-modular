<?php

namespace common\controllers;

use common\base\Controller;

class ErrorsController extends Controller
{
    public $layout = 'frontend/main';

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }
}