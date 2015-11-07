<?php

namespace modules\users\controllers;

use modules\users\components\ModuleController;
use modules\users\models\Users;
use common\exceptions\UserNotFoundException;
use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

/**
 * Class IndexController
 * @package app\modules\users\controllers
 */
class IndexController extends ModuleController
{
    /**
     * Renders list of users
     * @return string
     */
    public function actionIndex()
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
        return $this->render('create');
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
            $this->redirect(['/users/index/index']);
        } else {
            $model->load(['Users' => $model->user->toArray()]);

            return $this->render('edit', compact('model'));
        }
    }

    public function actionDelete($id)
    {
        $model = $this->getUserModel($id);
        if ($model->delete()) {
            $this->redirect(['/users/index/index']);
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