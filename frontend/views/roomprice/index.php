<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RoompriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Roomprices');
$this->params['breadcrumbs'][] = $this->title;
$result = Yii::$app->db->createCommand("SELECT id,title FROM hotel ORDER BY title")->queryAll(); ?>

<div class="roomprice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Roomprice'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'hotel_id',
                'header'=>'Hotel',
                'format' => 'raw',
                'value' => function($model) {
                    if(isset($model->hotel->title)) $title=$model->hotel->title;
                    else $title="N/A";
                    return $title;
                },
                'filter' => Html::activeDropDownList($searchModel, 'hotel_id',  ArrayHelper::map($result, 'id', 'title'),['class'=>'form-control','prompt' => 'All']),
                'contentOptions'=>['width'=>250]
            ],
            [
                'attribute' => 'room','contentOptions'=>['width'=>120]
            ],
            // 'room_note',
            // 'season',
            // 'meal_plan',
            'date_from',
            'date_to',
            'sgl_room',
            [
                'attribute' => 'dbl_person',
                'format' => 'raw',
                'value' => function($model) {
                    return round($model->dbl_person,0);
                },
            ],
            [
                'attribute' => 'third_pax',
                'format' => 'raw',
                'value' => function($model) {
                    return round($model->third_pax,0);
                },
            ],
            // 'adult_hb',
            // 'child_bb',
            // 'child_eb',
            // 'child_hb',
            // 'promotional',
            // 'booking_code',

            ['class' => 'yii\grid\ActionColumn','contentOptions'=>['width'=>80]],
        ],
    ]); ?>
</div>
