<?php

namespace modules\admin\controllers;

use Yii;
use modules\admin\components\ModuleController;
use modules\admin\models\Users;
use yii\web\NotFoundHttpException;


/**
 * Class IndexController
 * @package app\modules\admin\controllers
 */
class UsersController extends ModuleController
{
    /**
     * Renders list of users
     * @param null $id
     * @return string
     */
    public function actionIndex($id = null)
    {
        $model = new Users();
        $dataProvider = $model->getUsersProvider();

        return $this->render('index', compact('model', 'dataProvider'));
    }

    public function actionCreate()
    {
        echo 'CreateUser';
    }

    /**
     * User edit action
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEdit($id)
    {
        if ($model = Users::getUser($id)) {
            return $this->render('edit', compact('model'));
        }

        throw new NotFoundHttpException;
    }
}