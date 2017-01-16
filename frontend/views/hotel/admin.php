<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Hotels');
$this->params['breadcrumbs'][] = $this->title;
$country_result = Yii::$app->db->createCommand("SELECT id,title FROM country")->queryAll();
$city_result = Yii::$app->db->createCommand("SELECT id,title FROM city")->queryAll();
?>
<div class="hotel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Hotel'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'filter' => Html::activeDropDownList($searchModel, 'country_id', ArrayHelper::map($country_result, 'id', 'title'),['class'=>'form-control','prompt' => 'All']),
            ],
            [
                'attribute' => 'city_id',
                'header'=>'City',
                'format' => 'raw',
                'value' => function($model) {
                    if(isset($model->city->title)) $title=$model->city->title;
                    else $title="N/A";
                    return $title;
                },
                'filter' => Html::activeDropDownList($searchModel, 'city_id', ArrayHelper::map($city_result, 'id', 'title'),['class'=>'form-control','prompt' => 'All']),
            ],
            'sku',
            // 'neighborhood',
            // 'address',
            // 'image',
            // 'latlong',
            // 'sku',
            // 'stars',
            // 'location',
            // 'website',
            // 'phone',
            // 'thumb',
            // 'imglinks:ntext',
            // 'thumbs_sprite',

            ['class' => 'yii\grid\ActionColumn', 'contentOptions'=>['width'=>80]],
        ],
    ]); ?>
</div>
