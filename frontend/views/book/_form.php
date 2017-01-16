<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Hotel;

/* @var $this yii\web\View */
/* @var $model frontend\models\Book */
/* @var $form yii\widgets\ActiveForm */
$get=Yii::$app->request->get();
if(isset($get['room'])){

    $model->title=$get['room'].' '.$get['price_for_nights'].": US$".$get['price'].' from '.$get['date_from'].' to '.$get['date_to'];
    $model->hotel_id=$get['hotel_id'];
}
$hotel=Hotel::findOne($model->hotel_id);
$img=Html::img($hotel->thumb,['class'=>'list_thumb']);
$role=Yii::$app->user->identity->role;
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
                for($i=0;$i<$hotel->stars; $i++){
                    echo "<span class='glyphicon glyphicon-star list_star'></span>";
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
        <div class="mt5">
            <?php if(isset($get['room'])){
                ?>
                <?=trim($get['room'])?> from <?=$get['date_from']?> to <?=$get['date_to']?>
                <div class="bold"><?=$get['price_for_nights']?> : <span class="green">US$<?=$get['price']?></span></div>
            <?php
            } else echo $model->title; ?>
        </div>
    </div>
    <br />

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'hotel_id')->hiddenInput([])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true])->hint('Any additional information you would like to share about this order') ?>

    <?php if($role=='admin') echo $form->field($model, 'admin_note')->textInput(['maxlength' => true]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
