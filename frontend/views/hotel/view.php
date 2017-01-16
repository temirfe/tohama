<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\assets\PhotoSwipeAsset;

PhotoSwipeAsset::register($this);

/* @var $this yii\web\View */
/* @var $model frontend\models\Hotel */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hotels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if($model->imglinks){$imglinks=explode(',',$model->imglinks);}
if($model->thumblinks){$thumblinks=explode(',',$model->thumblinks);}
$webroot=Yii::getAlias('@web');
$img_forlder=$webroot.'/images/hotel'.$model->id;
include_once($webroot.'/photoswipe/_swipe.php');
?>
<div class="hotel-view row">
    <div class="col-md-9">
        <h1><?= Html::encode($this->title) ?>
            <span class="star_wrap">
                    <?php
                    if($model->stars){
                        for($i=0;$i<$model->stars; $i++){
                            echo "<span class='glyphicon glyphicon-star star'></span>";
                        }
                    }
                    ?>
                </span>
        </h1>
        <div class="black mb20">
            <span class="glyphicon glyphicon-map-marker orange"></span>
            <?php
            $address[]=$model->address;
            if (strpos($model->address, $model->neighborhood) !== false){$address[]=$model->neighborhood;}
            if (strpos($model->address, $model->city->title) == false){$address[]=$model->city->title;}
            if (strpos($model->address, $model->country->title) == false) {$address[]=$model->country->title;}
            echo implode(',',$address);

            if($model->latlong){echo Html::a('Show on map',"http://www.google.com/maps/place/".$model->latlong,['class'=>'ml10','target'=>'_blank']);}
            ?>
        </div>
        <div class='view_img_wrap rel mb20'>
            <div class="loader abs gallery_loading"></div>
            <?php
            if(!empty($imglinks[0])) {
                echo "<div class='main_img_wrap'>";
                echo Html::img($imglinks[0], ['class' => 'js_main_img img-responsive']);
                echo "<div class='abs open_gallery'>".Html::a("<span class='glyphicon glyphicon-zoom-in'></span>", '#', ['class' => 'js_photo_swipe', 'data-index' => '0'])."</div>";
                echo "</div>";
                if(!empty($thumblinks)){
                    echo "<div class='thumbs_wrap'><ul>";
                    $img_index = 0;
                    foreach ($thumblinks as $k=>$thumb){
                        $big=$imglinks[$k];
                        if($k==0) $thumb_class='js_prevent_default active_thumb'; else $thumb_class='js_open_thumb';
                        $img=Html::img($thumb,['class'=>'img-responsive js_img']);
                        echo '<li>'.Html::a($img,'#',['class'=>$thumb_class, 'data-big'=>$big, 'data-index'=>$img_index]).'</li>';
                        $img_index++;
                    }
                    echo "</ul></div>";
                }
            }
            ?>
        </div>
        <?=$model->text?>
    </div>
</div>
