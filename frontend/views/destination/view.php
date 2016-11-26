<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Destination */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Destinations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destination-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <span class="mr10"><?=$model->place;?></span>
    <span><?=$model->price?></span>
    <p><?=$model->text?></p>
    <div class="row">
        <div class="col-sm-12">
            <?=Html::img('/images/destination/'.$model->id.'/'.$model->image,['class'=>'img-responsive'])?>
        </div>
    </div>

</div>
