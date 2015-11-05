<?php

namespace modules\admin\controllers;

use common\exceptions\UserNotFoundException;
use Yii;
use modules\admin\components\ModuleController;
use modules\admin\models\Users;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

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
        $dataProvider = $this->getUsersProvider($model->getUsers());

        return $this->render('index', compact('model', 'dataProvider'));
    }

    /**
     * Returns Active data provider for grid
     * @param \yii\db\ActiveQuery $query
     * @return ActiveDataProvider
     */
    public function getUsersProvider($query)
    {
        return new ActiveDataProvider([
            'query' => $query
        ]);
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
        $model = $this->getUserModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['/admin/users']);
        } else {
            $model->load(['Users' => $model->user->toArray()]);

            return $this->render('edit', compact('model'));
        }
    }

    public function actionDelete($id)
    {
        $model = $this->getUserModel($id);
        if ($model->delete()) {
            $this->redirect(['/admin/users']);
        }
    }

    private function getUserModel($id)
    {
        try {
            $model = new Users($id);
        } catch (UserNotFoundException $e) {
            throw new NotFoundHttpException;
        }

        return $model;
    }
}