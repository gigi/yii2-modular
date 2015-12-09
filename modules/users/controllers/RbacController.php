<?php

namespace modules\users\controllers;

use modules\users\components\ModuleController;
use modules\users\models\AuthItem;
use yii\base\Exception;
use yii\base\InvalidValueException;
use yii\web\NotFoundHttpException;

class RbacController extends ModuleController
{
    public $authItemModel;

    /**
     * Render main grids
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new AuthItem();

        $rolesDataProvider = $this->getActiveDataProvider($model->getRoles());
        $permissionsDataProvider = $this->getActiveDataProvider($model->getPermissions());

        return $this->render('index', compact('model', 'rolesDataProvider', 'permissionsDataProvider'));
    }

    public function actionEdit($id)
    {
        $model = $this->getAuthItemModel($id);

        return $this->render('edit', compact('model'));
    }

    public function actionRoles()
    {
        return $this->render('index');
    }

    /**
     * Returns one model Auth item by it's name
     *
     * @param $id
     * @return \modules\users\models\AuthItem
     * @throws NotFoundHttpException
     */
    public function getAuthItemModel($id)
    {
        try {
            $model = new AuthItem($id);
        } catch (\InvalidArgumentException $e) {
            throw new NotFoundHttpException;
        }

        return $this->authItemModel = $model;
    }

    public function getAuthItem($id = null)
    {
        if (!$this->authItemModel) {
            $this->getAuthItemModel($id);
        }

        return $this->authItemModel->item;
    }

    /**
     * Just some rbac tests
     */
    private function tests()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll();

        $userRule = new \common\rbac\UserRule();
        $auth->add($userRule);

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create new post';
        $auth->add($createPost);

        $editUsers = $auth->createPermission('editUsers');
        $editUsers->description = 'Edit existing users';
        $auth->add($editUsers);

        $editProfile = $auth->createPermission('editProfile');
        $editProfile->description = 'Edit my profile via admin';
        $editProfile->ruleName = $userRule->name;
        $auth->add($editProfile);
        $auth->addChild($editProfile, $editUsers);

        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);
        $auth->addChild($author, $editProfile);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $editUsers);
        $auth->addChild($admin, $author);

        $auth->assign($admin, 6);
        $auth->assign($author, 9);

        echo '<pre>';
        var_dump(\Yii::$app->user->identity->email);

        var_dump('--------');
        var_dump('Admin createPost');
        var_dump($auth->checkAccess(6, 'createPost'));

        var_dump('--------');
        var_dump('Admin editUsers');
        var_dump($auth->checkAccess(6, 'editUsers'));

        var_dump('--------');
        var_dump('Author createPost');
        var_dump($auth->checkAccess(9, 'createPost'));

        var_dump('--------');
        var_dump('Author editUsers');
        var_dump($auth->checkAccess(9, 'editUsers'));

        var_dump('--------');
        var_dump('Current createPost');
        var_dump(\Yii::$app->user->can('createPost'));

        var_dump('--------');
        var_dump('Current editUsers');
        var_dump(\Yii::$app->user->can('editUsers', \Yii::$app->user->getId()));

        var_dump(\Yii::$app->user);

        echo '</pre>';
        exit;
    }
}