<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cities');
$this->params['breadcrumbs'][] = $this->title;
$result = Yii::$app->db->createCommand("SELECT id,title FROM country")->queryAll();
?>
<div class="city-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create City'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'contentOptions'=>['width'=>80]],
            'title',
            [
                'attribute' => 'country_id',
                'header'=>'Country',
                'format' => 'raw',
                'value' => function($model) {
                    if(isset($model->country->title)) $title=$model->country->title;
                    else $title="N/A";
                    return $title;
                },
                'filter' => Html::activeDropDownList($searchModel, 'country_id', ArrayHelper::map($result, 'id', 'title'),['class'=>'form-control','prompt' => 'All']),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
