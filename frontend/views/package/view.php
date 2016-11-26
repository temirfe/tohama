<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Package */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=$model->text ?>
    <?php
        $webroot=Yii::getAlias('@webroot');
        foreach($children as $child){
            echo "<div class='item_title mt10'>".$child['title']."<span class='label label-primary item_price ml10'>".$child['price']."</span></div>";
            echo "<div class='item_text mt5 mb15'>".$child['text']."</div>";
            $cid=$child['id'];
            if(is_dir($webroot."/images/item/".$cid)){
                $imgs=scandir($webroot."/images/item/".$cid);
                echo "<div class='row text-center'>";
                foreach($imgs as $img){
                    if($img!='.' && $img!='..'){
                        if(strpos($img,'s_' )!==false)
                        {
                            echo "<div class='col-md-4 mb15'>".Html::img("@web/images/item/".$cid."/".$img, ['class'=>'img-responsive', 'alt'=>'']).'</div>';
                        }
                    }
                }
                echo "</div>";
            }
        }
    ?>

</div>
