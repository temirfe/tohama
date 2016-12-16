<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DestinationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Destinations');
$this->params['breadcrumbs'][] = $this->title;
$dest_categ=['Being lazy on the beach',
    'Skiing',
    'Paragliding',
    'Kite Surfing',
    'Medical & cosmetology treatment',
    'Wine & Safari',
    'Hot offers'];
$ctg=[];
foreach($dest_categ as $key=>$val){
    $ctg[$key]=[];
}
foreach($destinations as $dest){
    $ctg[$dest['category_id']][]=$dest;
}
?>
<div class="destination-index">

    <h3>
        Destinations of
        <span class="highlight gold">your</span>
        interest
    </h3>
    <?php
        foreach($ctg as $ckey=>$cval){
            if($cval){
                echo "<h3>".$dest_categ[$ckey]."</h3>";
                echo "<div class='row'>";
                foreach($cval as $destination){
                    ?>
                    <div class="col-md-4 rel img_pack_box">
                        <div class="img_pack_wrap">
                            <?php
                            $img=Html::img("/images/destination/".$destination['id']."/s_".$destination['image'],['class'=>'img-responsive']);
                            echo "<div class='img_pack_thumb'>".Html::a($img,['destination/view','id'=>$destination['id']])."</div>";
                            ?>

                            <div class="img_pack_title pad15">
                                <h4 class="mt0 mb2">
                                    <?=Html::a($destination['title']."<span class='false_link'></span>",['destination/view','id'=>$destination['id']],['class'=>'no_underline black']);?>
                                </h4>
                                <div class="img_pack_text"><?=$destination['place'];?></div>
                            </div>

                        </div>
                    </div>
                    <?php
                }
                echo "</div>";
            }
        }
    ?>
</div>
