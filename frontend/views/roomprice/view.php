<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Roomprice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Roomprices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roomprice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'hotel_id',
            'country_id',
            'city_id',
            'market_id',
            'room',
            'room_note',
            'season',
            'meal_plan',
            'date_from',
            'date_to',
            'sgl_room',
            'dbl_person',
            'third_pax',
            'adult_hb',
            'child_bb',
            'child_eb',
            'child_hb',
            'promotional',
            'booking_code',
        ],
    ]) ?>

</div>
