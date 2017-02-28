<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Hotel*/
/* @var $cities */
?>

<div class="hotel-search row box hotel_list_box bg-f5 ">
    <h3 class="mt5 blue">Search</h3>

    <?php $form = ActiveForm::begin([
        'action' => ['/hotel/search'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'country_id')->dropDownList($countries,['prompt'=>'Select country..','id'=>'hotel-country_id']); ?>
    <?= $form->field($model, 'city_id')->dropDownList($cities,['prompt'=>'Select city..', 'id'=>'hotel-city_id']); ?>
    <?= $form->field($model, 'nationality_id')->dropDownList($nations,['prompt'=>'Select Nationality..']); ?>
    <div class="row">
        <div class="col-md-6 pr5">
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
        </div>
        <div class="col-md-6 pl5">
            <?php
            echo $form->field($model, 'date_to')->widget(DatePicker::classname(), [
                'options' => [],
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd M yyyy',
                ],
                'pluginEvents' => [
                    "changeDate" => "function(e) {endChange(e.date);}",
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="js_nights_count nights_count font12 mb5"><?=$night?>-night stay</div>

    <?= $form->field($model, 'stars')->dropDownList(['no preference','1 Star','2 Stars','3 Stars','4 Stars','5 Stars',8=>'Apartment',9=>'unrated']); ?>
    <div class="row mt15">
        <div class="col-md-6 pr0">
            <?= $form->field($model, 'adult')->dropDownList([1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10'],['class'=>'ml5']); ?>
        </div>
        <div class="col-md-6 pl0">
            <?= $form->field($model, 'children')->dropDownList(range(0,5),['class'=>'js_children children_sel']); ?>
        </div>
    </div>

    <div class="js_child_ages_label font12 gray5 mb2" data-date="<?=$model->date_to?>"></div>
    <div class="js_child_ages mb15">
        <?php
            if(!empty($get['child_age'])){
                foreach($get['child_age'] as $age){
                    echo $form->field($model, 'child_age[]')->dropDownList(range(0,17),['class'=>'mr5', 'id'=>false, 'value'=>$age])->label(false);
                }
            }
        ?>
        
    </div>
    <?= $form->field($model, 'title')->textInput(['placeholder'=>'Enter Hotel name (optional)'])->label('Hotel name') ?>
    

    <div class="form-group mt15">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <div class="js_child_here hidden">
        <?= $form->field($model, 'child_age[]')->dropDownList(range(0,17),['class'=>'mr5', 'id'=>false])->label(false); ?>
    </div>

</div>