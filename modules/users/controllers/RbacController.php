<?php

namespace modules\users\controllers;

use common\components\BackendController;

class RbacController extends BackendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Just some rbac tests
     */
    private function tests()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll();

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create new post';
        $auth->add($createPost);

        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        $editUsers = $auth->createPermission('editEsers');
        $editUsers->description = 'Edit existing users';
        $auth->add($editUsers);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $editUsers);
        $auth->addChild($admin, $author);

        $userRule = new \common\rbac\UserRule();
        $auth->add($userRule);



        $auth->assign($admin, 6);
        $auth->assign($author, 9);

        echo '<pre>';
        var_dump('--------');
        var_dump('Admin createPost');
        var_dump($auth->checkAccess(6, 'createPost'));

        var_dump('--------');
        var_dump('Admin editUsers');
        var_dump($auth->checkAccess(6, 'editEsers'));

        var_dump('--------');
        var_dump('Author createPost');
        var_dump($auth->checkAccess(9, 'createPost'));

        var_dump('--------');
        var_dump('Author editUsers');
        var_dump($auth->checkAccess(9, 'editEusers'));

        echo '</pre>';
        exit;
    }

    public function actionRoles()
    {
        return $this->render('index');
    }
}