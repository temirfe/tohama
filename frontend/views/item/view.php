<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\PackageItem */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Package Items'), 'url' => ['index']];
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
<div class="package-item-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?=Html::a("<button class='btn btn-default pull-right'>Go to package</button>",['/package/view','id'=>$model->parent_id])?>

    <h2><div class='label label-primary item_price'><?=$model->price;?></div></h2>
    <br />
    <div class='item_text mt5 mb15'><?=$model->text?></div>
    <?php
    $cid=$model->id;
    $webroot=Yii::getAlias('@webroot');
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
    } ?>
</div>
