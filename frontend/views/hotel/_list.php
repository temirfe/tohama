<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Hotel*/
if($model->thumb){
    $img=Html::img($model->thumb,['class'=>'list_thumb']);
}
else if($model->image){
    $img=Html::img("/images/hotel/".$model->id."/s_".$model->image,['class'=>'list_thumb']);
}
else $img="<div class='no_img text-center'>".Html::img("/images/tohama_logo_300px.png",['class'=>'slider'])."</div>";
$imglink=Html::a($img,['/hotel/view','id'=>$model->id],['class'=>'list_thumb rel']);
?>

<div class='pull-left article-thumb mr20'>
    <?=$imglink?>
</div>

<div class="oh">
    <div class="mt5">
        <?=Html::a($model->title,['/hotel/view','id'=>$model->id],['class'=>'hotel_list_title blue no_underline']); ?>
        <?php
        if($model->stars){
            for($i=0;$i<$model->stars; $i++){
                echo "<span class='glyphicon glyphicon-star list_star'></span>";
            }
        }
        ?>
    </div>
    <div class="color69">
        <?php if($model->neighborhood) echo $model->neighborhood.', '; 
            echo $model->city->title;
        if($model->latlong){echo Html::a('Show map',"http://www.google.com/maps/place/".$model->latlong,['class'=>'ml10 font12 purple','target'=>'_blank']);}
        ?>
    </div>
    <div class="mt10">
        <?php
            if($rowprices=$model->prices){
                $get=Yii::$app->request->get('HotelSearch');
                $stay_start=$get['date_from'];
                $stay_end=$get['date_to'];
                $stay_times=[];
                for($i=strtotime($stay_start);$i<strtotime($stay_end);$i+=86400){
                    $stay_times[]=$i;
                }
                $room=[];
                foreach($rowprices as $row){
                    $price_add=false;
                    if(!isset($room[$row->room])){$room[$row->room]['name']=$row->room; $room[$row->room]['meal_plan']=$row->meal_plan; $room[$row->room]['price']=0; $price_add=true;}
                    for($i=strtotime($row->date_from);$i<=strtotime($row->date_to);$i+=86400){
                        if(in_array($i,$stay_times)){
                            $room[$row->room]['price']+=$row->sgl_room;
                            //echo $row->room.' '.date('Y-m-d',$i).' '.$row->sgl_room."<br />";
                        }
                    }
                }
                if($room){
                    foreach($room as $r){
                        echo $r['name'].' '.$r['meal_plan'].' '.$r['price']."<br />";
                    }
                }

            }
        ?>
    </div>
</div>