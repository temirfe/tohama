<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Tohama Travel & Tourism';
?>
<style type="text/css">
    .logo_wrap {
        background: #fff url("/images/tohama_logo_300px.png") no-repeat scroll center center / 135px auto;
        box-shadow: 0 0 2px 1px #e7b674;
        height: 200px;
        margin-top: -1px;
        width: 163px;
    }
</style>
<div class="slider">
    <?=Html::img("images/bg_sunset.jpg")?>
</div>
<div class="slider_mask"></div>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-12">
                <h3>Explore <span class="highlight gold">UAE</span> with us</h3>
                <div class="row">
                    <?php
                    foreach($cities as $city){
                        ?>
                        <div class="col-sm-3 rel img_thumb_box">
                            <div class="photo_thumb">
                                <?php
                                $img=Html::img("/images/city/".$city['id']."/s_".$city['image'],['class'=>'img-responsive']);
                                echo Html::a($img,['city/view','id'=>$city['id']]);
                                ?>
                            </div>

                            <div class="abs img_title"><span><?=Html::a($city['title']."<div class='false_link'></div>",['city/view','id'=>$city['id']],['class'=>'no_underline']);?></span></div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>
