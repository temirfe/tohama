<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Hotels');
$this->params['breadcrumbs'][] = $this->title;
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
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'text:ntext',
            'country_id',
            'city_id',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
