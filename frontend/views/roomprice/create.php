<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Roomprice */

$this->title = Yii::t('app', 'Create Roomprice');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Roomprices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roomprice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
