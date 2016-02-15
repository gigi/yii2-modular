<?php

/*
 * This file is part of the Yii2-modular skeleton https://github.com/gigi/yii2-modular
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace modules\users\controllers;

use common\components\Helper;
use modules\users\components\ModuleController;
use modules\users\models\AuthItem;
use modules\users\models\Permission;
use modules\users\models\Role;
use yii\helpers\Html;
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
        $rolesModel = new Role();
        $permissionsModel = new Permission();

        $roles = $this->renderModels($rolesModel);
        $permissions = $this->renderModels($permissionsModel);

        return $this->render('index', compact('roles', 'permissions'));
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreateRole()
    {
        $rolesModel = new Role();

        return $this->renderEditForm($rolesModel);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreatePermission()
    {
        $permissionModel = new Permission();

        return $this->renderEditForm($permissionModel);
    }

    /**
     * Edit role
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEditRole($id)
    {
        $model = $this->getRole($id);

        return $this->renderEditForm($model);
    }

    /**
     * Edit permission
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEditPermission($id)
    {
        $model = $this->getPermission($id);

        return $this->renderEditForm($model);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDeletePermission($id)
    {
        $model = $this->getPermission($id);

        if ($this->getAuthManager()->delete($model)) {
            return $this->redirect(['rbac/index']);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDeleteRole($id)
    {
        $model = $this->getRole($id);

        if ($this->getAuthManager()->delete($model)) {
            return $this->redirect(['rbac/index']);
        }
    }

    /**
     * @param AuthItem $model
     * @return string|\yii\web\Response
     */
    public function renderEditForm($model)
    {
        if ($model->load($this->getRequest()->post()) && $this->getAuthManager()->save($model)) {
            return $this->redirect(['rbac/index']);
        }
        $children = $this->convertChildrenList($model->getPossibleChildrenArray());
        $model->setChildren(array_keys($this->getAuthManager()->getChildren($model->getName())));
        $form = $this->renderPartial('_editForm', [
            'model' => $model,
            'children' => $children
        ]);

        return $this->render('create', compact('form'));
    }

    /**
     * Returns items formatted for Yii checkbox [name => label]
     *
     * @param array $children
     * @return array
     */
    public function convertChildrenList($children)
    {
        $result = [];
        foreach ($children as $child) {
            $label = $child->getName();
            if (!empty($child->getDescription())) {
                $label .= Html::tag('small',  ' ('. $child->getDescription() . ')');
            }
            $typeLabel = $child->getLabel();
            $result[$typeLabel][$child->getName()] = $label;
        }

        return $result;
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

    /**
     * Returns role item
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function getRole($id)
    {
        $role = $this->getAuthManager()->getRole($id);
        if (empty($role)) {
            throw new NotFoundHttpException;
        }

        return $role;
    }

    /**
     * Returns permission item
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function getPermission($id)
    {
        $permission = $this->getAuthManager()->getPermission($id);
        if (empty($permission)) {
            throw new NotFoundHttpException;
        }

        return $permission;
    }

    /**
     * Just some rbac tests
     */
    public function actionTest()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll();

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create new post';
        $auth->add($createPost);

        $editUsers = $auth->createPermission('editUsers');
        $editUsers->description = 'Edit existing users';
        $auth->add($editUsers);

        $userRule = new \common\rbac\UserRule();
        $auth->add($userRule);

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