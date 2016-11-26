<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\PackageItem */

$this->title = Yii::t('app', 'Create Package Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Package Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'packages'=>$packages
    ]) ?>

</div>
