<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Destination */

$this->title = Yii::t('app', 'Create Destination');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Destinations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destination-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
