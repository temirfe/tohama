<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PackageItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Package Items');
$this->params['breadcrumbs'][] = $this->title;
$result = Yii::$app->db->createCommand("SELECT id,title FROM package ORDER BY id DESC")->queryAll(); ?>

<div class="package-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Package Item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'contentOptions'=>['width'=>80]],
            [
                'attribute' => 'parent_id',
                'header'=>'Package',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->package->title;
                },
                'filter' => Html::activeDropDownList($searchModel, 'parent_id', ArrayHelper::map($result, 'id', 'title'),['class'=>'form-control','prompt' => 'All']),
            ],
            [
                'attribute' => 'title',
                'header'=>'Package Item',
            ],
            // 'price',

            ['class' => 'yii\grid\ActionColumn', 'contentOptions'=>['width'=>80]],
        ],
    ]); ?>
</div>
