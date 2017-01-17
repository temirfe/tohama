<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

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
if($get){
    $model->country_id=$get['country_id'];
    $model->city_id=$get['city_id'];
    $model->nationality_id=$get['nationality_id'];
}

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

if(!empty($index)){include_once('_search_html_index.php');}else{include_once('_search_html.php');}