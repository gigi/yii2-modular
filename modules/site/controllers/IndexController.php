<?php

namespace modules\site\controllers;

use modules\site\models\Confirm;
use modules\site\models\Login;
use modules\site\models\Register;
use modules\site\components\ModuleController;

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
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Login::logout();
        return $this->goHome();
    }

    public function actionRegister()
    {
        $model = new Register();
        if ($model->load(\Yii::$app->request->post())) {
            if ($user = $model->register()) {
                if (\Yii::$app->getUser()->login($user)) {
                    return $this->render('register', [
                        'model' => $model,
                        'needConfirmation' => true
                    ]);
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
        $model = new Confirm($token);
        if ($model->load(\Yii::$app->request->post()) && $model->confirm()) {
            return $this->goBack();
        }

        return $this->render('confirm', compact('model'));
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}