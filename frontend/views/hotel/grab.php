<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Add Hotel from link');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php
        echo Html::beginForm();
        echo "<div class='from-group'>";
        echo Html::textInput('url','',['class'=>'form-control','placeholder'=>'Url from booking.com']);
        echo "</div>";
        echo "<div class='form-group mt20'>".Html::submitButton('Submit', ['class' => 'submit btn btn-primary js_grab_submit'])."</div>";
        echo Html::endForm();
    ?>
    <div class="hiddeniraak js_grab_loading">
        <div class="loader pull-left"></div> <span class="ml10 iblock mt6">Grabbing content...</span>
    </div>
</div>
