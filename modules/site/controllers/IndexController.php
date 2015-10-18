<?php

namespace modules\site\controllers;

use modules\site\models\Login;
use modules\site\models\Register;
use modules\site\components\ModuleController;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

/**
 * Class IndexController
 * @package app\modules\site\controllers
 */
class IndexController extends ModuleController
{
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Login();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        echo 'Logout';
    }

    public function actionRegister()
    {
        $model = new Register();
        if ($model->load(\Yii::$app->request->post())) {
            if ($user = $model->register()) {
                if (\Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionForgotten()
    {
        echo 'Forgotten';
    }

    public function actionConfirm($token)
    {
        $model = new Register();
        try {
            $model->confirm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }


    }

    public function actionIndex()
    {
        $model = new Login();

        return $this->render('index', compact('model'));
    }
}