<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Hotels');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="hotel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-md-4">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="col-md-8">
        <?php Pjax::begin(); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item box hotel_list_box'],
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_list',['model' => $model]);
            },
            'summary'=>''
        ]) ?>
        <?php Pjax::end(); ?>
    </div>
</div>
