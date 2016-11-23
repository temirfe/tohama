<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">
    <!--<div class="col-md-4"></div>
    <div class="col-md-8">

    </div>-->

    <h1><?= Html::encode($this->title) ?></h1>

    <?=$model->text ?>

</div>
