<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RoompriceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="roomprice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'hotel_id') ?>

    <?= $form->field($model, 'country_id') ?>

    <?= $form->field($model, 'city_id') ?>

    <?= $form->field($model, 'market_id') ?>

    <?php // echo $form->field($model, 'room') ?>

    <?php // echo $form->field($model, 'room_note') ?>

    <?php // echo $form->field($model, 'season') ?>

    <?php // echo $form->field($model, 'meal_plan') ?>

    <?php // echo $form->field($model, 'date_from') ?>

    <?php // echo $form->field($model, 'date_to') ?>

    <?php // echo $form->field($model, 'sgl_room') ?>

    <?php // echo $form->field($model, 'dbl_person') ?>

    <?php // echo $form->field($model, 'third_pax') ?>

    <?php // echo $form->field($model, 'adult_hb') ?>

    <?php // echo $form->field($model, 'child_bb') ?>

    <?php // echo $form->field($model, 'child_eb') ?>

    <?php // echo $form->field($model, 'child_hb') ?>

    <?php // echo $form->field($model, 'promotional') ?>

    <?php // echo $form->field($model, 'booking_code') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
