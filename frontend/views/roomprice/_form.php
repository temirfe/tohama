<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Roomprice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="roomprice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hotel_id')->textInput() ?>

    <?= $form->field($model, 'country_id')->textInput() ?>

    <?= $form->field($model, 'city_id')->textInput() ?>

    <?= $form->field($model, 'market_id')->textInput() ?>

    <?= $form->field($model, 'room')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'room_note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'season')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meal_plan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_from')->textInput() ?>

    <?= $form->field($model, 'date_to')->textInput() ?>

    <?= $form->field($model, 'sgl_room')->textInput() ?>

    <?= $form->field($model, 'dbl_person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'third_pax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adult_hb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'child_bb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'child_eb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'child_hb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'promotional')->textInput() ?>

    <?= $form->field($model, 'booking_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
