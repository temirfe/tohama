<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PackageItem;
use frontend\models\PackageItemSearch;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

/**
 * ItemController implements the CRUD actions for PackageItem model.
 */
class ItemController extends MyController
{

    /**
     * Lists all PackageItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackageItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PackageItem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PackageItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PackageItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            $dao=Yii::$app->db;
            $result = $dao->createCommand("SELECT id,title FROM package ORDER BY `id` DESC")->queryAll();
            $res=ArrayHelper::map($result,'id','title');
            return $this->render('create', [
                'model' => $model,
                'packages'=>$res,
            ]);
        }
    }

    /**
     * Updates an existing PackageItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $dao=Yii::$app->db;
            $result = $dao->createCommand("SELECT id,title FROM package ORDER BY `id` DESC")->queryAll();
            $res=ArrayHelper::map($result,'id','title');
            return $this->render('update', [
                'model' => $model,
                'packages'=>$res,
            ]);
        }
    }

    /**
     * Deletes an existing PackageItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PackageItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PackageItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PackageItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
