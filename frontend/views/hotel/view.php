<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Hotel */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if($model->imglinks){$imglinks=explode(',',$model->imglinks);}

?>
<div class="hotel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        if(!empty($imglinks[0])){echo Html::img($imglinks[0],[]);}
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'text:ntext',
            'country_id',
            'city_id',
            'neighborhood',
            'address',
            'image',
            'latlong',
            'sku',
            'stars',
        ],
    ]) ?>

</div>
