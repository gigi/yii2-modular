<?php

namespace modules\users\controllers;

use modules\users\components\ModuleController;
use common\exceptions\UserNotFoundException;
use yii\web\NotFoundHttpException;
use modules\users\services\Users as UserService;

/**
 * Class IndexController
 *
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
        $dataProvider = $this->getActiveDataProvider(UserService::findAllQuery());
        $getStatus = function($status = null) {
            return UserService::getStatuses($status);
        };

        return $this->render('index', compact('model', 'dataProvider', 'getStatus'));
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
        $userService = $this->getUserService($id);
        if ($userService->setUserParams(\Yii::$app->request->post()) && $userService->saveUser()) {
            return $this->redirect(['/users/index/index']);
        }
        $statuses = UserService::getStatuses();

        return $this->render('edit', [
            'model' => $userService->getUserModel(),
            'statuses' => $statuses
        ]);
    }

    public function actionDelete($id)
    {
        $service = $this->getUserService($id);
        if ($service->deleteUser()) {
            $this->redirect(['/users/index/index']);
        }
    }

    /**
     * @param $id
     * @return \modules\users\services\Users
     * @throws NotFoundHttpException
     */
    private function getUserService($id)
    {
        $service = new UserService;
        try {
            $service->findById($id);
        } catch (UserNotFoundException $e) {
            throw new NotFoundHttpException;
        }

        return $service;
    }
}