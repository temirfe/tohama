<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Destination */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Destination',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Destinations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="destination-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
