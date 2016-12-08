<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {

        $auth = Yii::$app->authManager;
        //$admin = $auth->getRole('admin');
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->assign($admin, 1);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($admin, $user);

        $create = $auth->createPermission('create');
        $update = $auth->createPermission('update');
        $delete = $auth->createPermission('delete');
        $index = $auth->createPermission('index');
        $crud = $auth->createPermission('crud');
        $view = $auth->createPermission('view');
        $auth->add($create);
        $auth->add($update);
        $auth->add($delete);
        $auth->add($index);
        $auth->add($crud);
        $auth->add($view);
        $auth->addChild($user, $view);
        $auth->addChild($crud, $create);
        $auth->addChild($crud, $update);
        $auth->addChild($crud, $delete);
        $auth->addChild($admin, $crud);
        $auth->addChild($admin, $index);
    }
}
