<?php

namespace modules\users\controllers;

use common\components\Helper;
use modules\users\components\ModuleController;
use modules\users\models\AuthItem;
use modules\users\models\Permissions;
use modules\users\models\Roles;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class RbacController extends ModuleController
{
    /**
     * Render main grids
     *
     * @return string
     */
    public function actionIndex()
    {
        $rolesModel = new Roles();
        $permissionsModel = new Permissions();

        $roles = $this->renderModels($rolesModel);
        $permissions = $this->renderModels($permissionsModel);

        return $this->render('index', compact('roles', 'permissions'));
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreateRole()
    {
        $rolesModel = new Roles();

        return $this->renderEditForm($rolesModel);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreatePermission()
    {
        $permissionModel = new Permissions();

        return $this->renderEditForm($permissionModel);
    }

    /**
     * @param AuthItem $model
     * @return string|\yii\web\Response
     */
    public function renderEditForm($model)
    {
        if ($model->load($this->getRequest()->post()) && $model->save()) {
            return $this->redirect(['rbac/index']);
        }

        $form = $this->renderPartial('_editForm', [
            'model' => $model
        ]);

        return $this->render('create', compact('form'));
    }

    /**
     * Renders _authItems grid
     *
     * @param AuthItem $model
     * @return string
     */
    public function renderModels(AuthItem $model)
    {
        $modelId = Helper::singularize($model->getUniqueId());

        return $this->renderPartial('_authItems', [
            'dataProvider' => $model->getDataProvider(),
            'modelId' => $modelId,
            'title' => $model->getAttributeLabel('type')
        ]);
    }

    public function actionEditRole($id)
    {
        $model = new Roles();
        if (!$model->loadByName($id)) {
            throw new NotFoundHttpException;
        }

        $form = $this->renderPartial('_editForm', [
            'model' => $model
        ]);

        return $this->render('create', compact('form'));
    }

    /**
     * Just some rbac tests
     */
    public function actionTest()
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