<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\City */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=$model->text ?>
    <br />
    <br />
    <?=Html::img("/images/city/".$model->id."/".$model->image,['class'=>'img-responsive'])?>

</div>
