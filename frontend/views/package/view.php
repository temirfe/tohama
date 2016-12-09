<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Package */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '70%',
        'height' => '70%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'locked'=>false,
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);
?>
<div class="package-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-9">
            <div class="row mb15">
                <div class="col-md-12">
                    <?=Html::img("@web/images/package/".$model->id."/".$model->image, ['class'=>'img-responsive', 'alt'=>''])?>
                </div>
            </div>
            <?=$model->text ?>
            <br />
            <br />
            <?php
                $webroot=Yii::getAlias('@webroot');
                foreach($children as $child){
                    echo "<div id='section{$child['id']}' class='mb20 bbgray pt60'>";
                    echo "<div class='item_title mb15'>".$child['title']."</div>";
                    echo "<span class='label label-primary item_price font16 mb10 iblock'>".$child['price']."</span>";
                    echo "<div class='item_text mt5 mb15'>".$child['text']."</div>";
                    $cid=$child['id'];
                    if(is_dir($webroot."/images/item/".$cid)){
                        $imgs=scandir($webroot."/images/item/".$cid);
                        echo "<div class='row text-center'>";
                        foreach($imgs as $img){
                            if($img!='.' && $img!='..'){
                                if(strpos($img,'s_' )!==false)
                                {
                                    $thumb=Html::img("@web/images/item/".$cid."/".$img, ['class'=>'img-responsive', 'alt'=>'']);
                                    $limg=str_replace('s_','',$img);
                                    $large="@web/images/item/".$cid."/".$limg;
                                    $imga=Html::a($thumb,$large, ['rel' => 'fancybox']);
                                    echo "<div class='col-md-4 mb15'>".$imga.'</div>';
                                }
                            }
                        }
                        echo "</div>";
                    }
                    echo "</div>";
                }
            ?>
        </div>
        <div class="col-md-3 pr0">
            <div id="myScrollspy">
                <nav class="bs-docs-sidebar hidden-print hidden-sm hidden-xs" data-spy="affix" data-offset-top="75">
                    <ul class="nav bs-docs-sidenav">
                        <?php
                        foreach($children as $child){
                            ?>
                            <li>
                                <a href="#section<?=$child['id']?>"><?=$child['title']?></a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>



</div>
