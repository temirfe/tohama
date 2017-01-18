<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $error string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$name="Excel Upload";
$this->title = $name.' - Tohama Travel & Tourism LLC';

$dao=Yii::$app->db;
$country_query = $dao->createCommand("SELECT id,title FROM country")->queryAll();
$countries=ArrayHelper::map($country_query,'id','title');

$country_id=234; //UAE by preselected

$city_query = $dao->createCommand("SELECT id,title FROM city WHERE country_id='{$country_id}'")->queryAll();
$cities=ArrayHelper::map($city_query,'id','title');
$city_id=1; //Dubai by default
?>
<div class="site-error">

    <h1><?= Html::encode($name) ?></h1>

    <?php
    if($error){
        ?>
        <div class="alert alert-danger">
            <?= nl2br(Html::encode($error)) ?>
        </div>
    <?php
    }
    ?>

    <?=Html::beginForm('','post',['enctype' => 'multipart/form-data','role'=>'form','class'=>'js_excel_form']);?>
    <div class="form-group oh">
            <?= Html::label('Select file:', 'hf', ['style'=>'margin-right:10px;']) ?>
            <?= Html::fileInput('excel','',['id'=>'hf','style'=>'display:inline-block;']); ?>
    </div>
    <div class="form-group">
        <?= Html::dropDownList('country',$country_id, $countries,['prompt'=>'Select Country..','id'=>'hotel-country_id']); ?>
    </div>
    <div class="form-group">
        <?= Html::dropDownList('city',$city_id, $cities,['prompt'=>'Select City..', 'id'=>'hotel-city_id']); ?>
    </div>
    <!--<div class="form-group">
        <?/*= Html::dropDownList('stars',null, ['Select Stars...','1','2','3','4','5',8=>'Apartment',9=>'unrated'],[]); */?>
    </div>-->

    <div class="form-group oh clear">
        <?= Html::submitButton('Upload',['class'=>'btn btn-sm btn-primary js_grab_submit']) ?>
    </div>

    <?=Html::endForm(); ?>

    <div class="hiddeniraak js_grab_loading">
        <div class="loader pull-left"></div> <span class="ml10 iblock mt6">Uploading and processing...</span>
    </div>

</div>
