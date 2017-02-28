<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Hotel;

/* @var $this yii\web\View */
/* @var $model frontend\models\Book */
/* @var $form yii\widgets\ActiveForm */
$dao=Yii::$app->db;
$get=Yii::$app->request->get();
if(isset($get['room'])){

    $model->title=$get['room'].' '.$get['price_for_nights'].": US$".$get['price'].' from '.$get['date_from'].' to '.$get['date_to'];
    $model->hotel_id=$get['hotel_id'];
    $model->excel_id=$get['ex_id'];
    if($get['children']){
        $children=$get['children'].' aged:'.$get['child_ages'];
    }
    else { $children=0;}
    if($get['nationality']){
        $result = $dao->cache(function ($dao) {
            return $dao->createCommand("SELECT id,title FROM country")->queryAll();
        }, 86000);
        $nataray=\yii\helpers\ArrayHelper::map($result,'id','title');
        $nationality=$nataray[$get['nationality']];
    }
    else {$nationality='N/A';}
    $model->admin_note='adult: '.$get['adults'].'; children: '.$children.'; nationality: '.$nationality;
}

$info_rows=$dao->createCommand("SELECT * FROM sheetinfo WHERE excel_id='{$model->excel_id}' AND hotel_id='{$model->hotel_id}'")->queryAll();

$hotel=Hotel::findOne($model->hotel_id);
$img=Html::img($hotel->thumb,['class'=>'list_thumb']);
if(Yii::$app->user->identity) $role=Yii::$app->user->identity->role;

?>

<div class="book-form">

    <div class='pull-left article-thumb mr20 mt10'>
        <?=Html::a($img,['/hotel/view','id'=>$model->id],['class'=>'list_thumb rel'])?>
    </div>
    <div class="oh">
        <div class="mt5">
            <?=Html::a($hotel->title,['/hotel/view','id'=>$hotel->id],['class'=>'hotel_list_title blue no_underline']); ?>
            <?php
            if($hotel->stars){
                if($hotel->stars==8){echo "<span class='label label-default font12 ml10'>Apartment</span>";}
                else if($hotel->stars==9){/*do nothing, it's unrated*/}
                else{
                    for($i=0;$i<$hotel->stars; $i++){
                        echo "<span class='glyphicon glyphicon-star star'></span>";
                    }
                }
            }
            ?>
        </div>
        <div class="color69">
            <?php if($hotel->neighborhood) echo $hotel->neighborhood.', ';
            echo $hotel->city->title;
            if($hotel->latlong){echo Html::a('Show map',"http://www.google.com/maps/place/".$hotel->latlong,['class'=>'ml10 font12 purple','target'=>'_blank']);}
            ?>
        </div>
    </div>
    <br />

    <div class="mt5 oh">
        <?php if(isset($get['room'])){
            ?>
            <?=trim($get['room'])?>
            <div class="color5">from <?=$get['date_from']?> to <?=$get['date_to']?></div>
            <div class="bold"><?=$get['price_for_nights']?> : <span class="green">US$<?=$get['price']?></span></div>
            <?php
        } else echo $model->title; ?>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true])->hint('Any additional information you would like to share about this order') ?>

    <?php if(!empty($role) && $role=='admin') echo $form->field($model, 'admin_note')->textInput(['maxlength' => true]); ?>
    
    <?php if(!$model->isNewRecord){$model->read='1';} echo $form->field($model, 'read')->checkbox([]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'hotel_id')->hiddenInput([])->label(false) ?>
    <?= $form->field($model, 'excel_id')->hiddenInput([])->label(false) ?>

    <?php ActiveForm::end(); ?>



    <div class="terms mt20" id="terms">
        <h4 class="real_red">Hotel Terms & Conditions</h4>
        <?php
        if(!empty($info_rows)){
            foreach($info_rows as $ir){
                echo $ir['title'];
                echo "<table class=''>".$ir['description']."</table>";
            }
        }
        ?>
    </div>

</div>
