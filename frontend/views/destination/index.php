<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DestinationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Destinations');
$this->params['breadcrumbs'][] = $this->title;
$dest_categ=['Being lazy on the beach',
    'Skiing',
    'Paragliding',
    'Kite Surfing',
    'Medical & cosmetology treatment',
    'Wine & Safari',
    'Hot offers'];
?>
<div class="destination-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Destination'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'contentOptions'=>['width'=>80]],
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::img('/images/destination/'.$model->id.'/s_'.$model->image,['class'=>'w100']);
                },
                'contentOptions'=>['width'=>180]
            ],
            'title',
            [
                'attribute' => 'category_id',
                'header'=>'Category',
                'format' => 'raw',
                'value' => function($model) use($dest_categ) {
                    return $dest_categ[$model->category_id];
                },
                'filter' => Html::activeDropDownList($searchModel, 'category_id', $dest_categ,['class'=>'form-control','prompt' => 'All']),
                'contentOptions'=>['width'=>250]
            ],
            // 'price',
            // 'place',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
