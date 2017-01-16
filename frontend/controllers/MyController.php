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
                'roles' => ['?','@'],
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
                'only'=>['create','update','delete','index','view','grab'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete','grab','index'],
                        'allow' => true,
                        'roles' => ['crud'],
                    ],
                    $view,
                ],
            ],
        ];
    }
}
