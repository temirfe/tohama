<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use yii\web\ForbiddenHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class MyController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        if($this->id=='user' && $this->action->id=='view'){
            $view=[
                'actions' => ['view'],
                'allow' => true,
                'roles' => ['admin'],
            ];
        }
        else{
            $view=[
                'actions' => ['view'],
                'allow' => true,
                'roles' => ['view'],
            ];
        }
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create','update','delete'],
                        'allow' => true,
                        'roles' => ['crud'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['crud'],
                    ],
                    $view,
                ],
            ],
        ];
    }
}
