<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\HotelSearch */
/* @var $form yii\widgets\ActiveForm */
$dao=Yii::$app->db;
$nation_query = $dao->createCommand("SELECT id,title FROM country")->queryAll();
$country_query = $dao->createCommand("SELECT country_id,title FROM existing_countries")->queryAll();
$countries=ArrayHelper::map($country_query,'country_id','title');
$nations=ArrayHelper::map($nation_query,'id','title');

if($model->country_id){
    $city_query = $dao->createCommand("SELECT id,title FROM city WHERE country_id='{$model->country_id}'")->queryAll();
    $cities=ArrayHelper::map($city_query,'id','title');
}
else$cities=[];

$get=Yii::$app->request->get('HotelSearch');
$model->country_id=$get['country_id'];
$model->city_id=$get['city_id'];
$model->nationality_id=$get['nationality_id'];

if($get['date_from']){$model->date_from=$get['date_from'];}
else{
    $model->date_from=date('d M Y', strtotime('+2 days'));
}
if($get['date_to']){$model->date_to=$get['date_to'];}
else{
    $model->date_to=date('d M Y', strtotime('+9 days'));
}
$time_end=strtotime($model->date_to);
$time_start=strtotime($model->date_from);
$datediff=$time_end-$time_start;
$night=floor($datediff / (60 * 60 * 24));
?>

<div class="hotel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'country_id')->dropDownList($countries,['prompt'=>'Select country..','id'=>'hotel-country_id']); ?>
    <?= $form->field($model, 'city_id')->dropDownList($cities,['prompt'=>'Select city..', 'id'=>'hotel-city_id']); ?>
    <?= $form->field($model, 'nationality_id')->dropDownList($nations,['prompt'=>'Select Nationality..']); ?>
    <?php
    echo $form->field($model, 'date_from')->widget(DatePicker::classname(), [
        'options' => [],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'removeButton' => false,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd M yyyy',
            'todayHighlight' => true
        ],
        'pluginEvents' => [
            "changeDate" => "function(e) {startChange(e.date);}",
        ]
    ]);
    ?>
    <?php
    echo $form->field($model, 'date_to')->widget(DatePicker::classname(), [
        'options' => [],
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'removeButton' => false,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd M yyyy',
            'startDate'=>date('d/m/Y', strtotime('+1 days'))
        ]
    ]);
    ?>
    <div class="js_nights_count nights_count"><?=$night?>-night stay</div>


    <?php // echo $form->field($model, 'stars') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">

    window.onload=function(){
    };
</script>