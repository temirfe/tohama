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

$get=Yii::$app->request->get('HotelSearch');
$for='';
if($get['date_from'] && $get['date_to']){
    $time_end=strtotime($get['date_to']);
    $time_start=strtotime($get['date_from']);
    $datediff=$time_end-$time_start;
    $night=floor($datediff / (60 * 60 * 24));
    if($night>1){$s='s';}else{$s='';}
    $for="Price for {$night} night{$s}";
}
?>

<div class='pull-left article-thumb mr20'>
    <?=$imglink?>
</div>

<div class="oh">
    <div class="mt5">
        <?=Html::a($model->title,['/hotel/view','id'=>$model->id],['class'=>'hotel_list_title blue no_underline']); ?>
        <?php
        if($model->stars){
            if($model->stars==6){echo "<span class='label label-default ml10'>Apartment</span>";}
            else{
                echo "<span class='iblock'>";
                for($i=0;$i<$model->stars; $i++){
                    echo "<span class='glyphicon glyphicon-star list_star'></span>";
                }
                echo "</span>";
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
                    ?>
                    <table class="table book-table mb0 js_tbl_<?=$model->id?>">
                        <?php
                        $i=0;
                        foreach($room as $r){
                            if($i!=0){$additional_book_row='js_book_row_additional hiddeniraak';}else{$additional_book_row='';}
                            $book=Html::a("Book",['book/create', 'room'=>$r['name'],
                                'price'=>$r['price'], 'price_for_nights'=>$for, 'hotel_id'=>$model->id, 'other'=>'',
                                'date_from'=>$stay_start, 'date_to'=>$stay_end],['class'=>'btn btn-success btn-sm']);
                            ?>
                            <tr class="<?=$additional_book_row?>">
                                <td><?=$r['name']?></td>
                                <td><?=$r['meal_plan']?></td>
                                <td class='orange'>On Request</td>
                                <td><span class='gray5 mr10'><?=$for?>:</span><span class='blue font17'>US$<?=$r['price']?></span></td>
                                <td><?=$book?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </table>
                    <?=Html::a('&nbsp;&nbsp;Show more room types','#',['class'=>'js_show_additional_book_rows no_underline green','data-id'=>$model->id])?>

        <?php
                }

            }
        ?>
    </div>
</div>