<?php
use yii\helpers\Html;
?>
<style type="text/css">
    .navbar-fixed-top, .navbar-fixed-bottom {
        position: relative;
    }
    .wrap > .container {
        padding-top: 0;
    }
</style>
<?php
$pages_active='';
$package_active='';
$item_active='';
$dest_active='';
$user_active='';
$hotel_active='';
$city_active='';
$excel_active='';
$book_active='';
$price_active='';
$banner_active='';
$controller=Yii::$app->controller->id;
if($controller=='page') $pages_active="active";
else if($controller=='package') $package_active="active";
else if($controller=='item') $item_active="active";
else if($controller=='destination') $dest_active="active";
else if($controller=='user') $user_active="active";
else if($controller=='hotel') $hotel_active="active";
else if($controller=='city') $city_active="active";
else if($controller=='book') $book_active="active";
else if($controller=='roomprice') $price_active="active";
else if($controller=='banner') $banner_active="active";
else if($controller=='site' && Yii::$app->controller->action->id=='upload-excel') $excel_active="active";
?>
<div class="admpanel_top">
      <div class="admpanel-title">
          <div class="admpanel-title-wrapper">Admin panel<span class="openclose js_openclose">Hide - </span></div>
      </div>
      <div class="admpanel-content js_admpanel-content">
      	<div class="top_admpanel_wrapper">
            <div class="operations">
                <div class="<?=$pages_active?>"><span class='panel-icon glyphicon glyphicon-file'></span><?=Html::a('Pages', ['/page/index']); ?></div>
                <div class="<?=$package_active?>"><span class='panel-icon glyphicon glyphicon-tags'></span><?=Html::a('Packages', ['/package/index']); ?></div>
                <div class="<?=$item_active?>"><span class='panel-icon glyphicon glyphicon-tag'></span><?=Html::a('Package Items', ['/item/index']); ?></div>
                <div class="<?=$dest_active?>"><span class='panel-icon glyphicon glyphicon-globe'></span><?=Html::a('Destinations', ['/destination/index']); ?></div>
                <div class="<?=$city_active?>"><span class='panel-icon glyphicon glyphicon-map-marker'></span><?=Html::a('Cities', ['/city/index']); ?></div>
                <div class="<?=$hotel_active?>"><span class='panel-icon glyphicon glyphicon-home'></span><?=Html::a('Hotels', ['/hotel/admin']); ?></div>
                <div class="<?=$book_active?>"><span class='panel-icon glyphicon glyphicon-credit-card'></span><?=Html::a('Bookings', ['/book/index']); ?></div>
                <div class="<?=$excel_active?>"><span class='panel-icon glyphicon glyphicon-file'></span><?=Html::a('Upload excel', ['/site/upload-excel']); ?></div>
                <div class="<?=$price_active?>"><span class='panel-icon glyphicon glyphicon-barcode'></span><?=Html::a('Hotel prices', ['/roomprice/index']); ?></div>
                <div class="<?=$banner_active?>"><span class='panel-icon glyphicon glyphicon-picture'></span><?=Html::a('Banner', ['/banner/index']); ?></div>
                <div class="<?=$user_active?>"><span class='panel-icon glyphicon glyphicon-user'></span><?=Html::a('Users', ['/user/index']); ?></div>
             </div>
             <div class="clear"></div>
                <?php
                $id=Yii::$app->request->get('id');
                $action=Yii::$app->controller->action->id;
                if($action=='view' && $id)
                {
                    ?>
                    <div class="operations" style="padding: 4px 13px; background-color: #000;">
                        <?= Html::a('<span class="glyphicon glyphicon-list panel-icon2"></span> List', ['index'], ['class' => 'mr30']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-plus panel-icon2"></span> Create', ['create'], ['class' => 'mr30']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-pencil panel-icon2"></span> Update', ['update', 'id' => $id], ['class' => 'mr30']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-remove panel-icon2"></span> Delete', ['delete', 'id' => $id], [
                            'data' => [
                                'confirm' => 'Are you sure you want to delete?',
                                'method' => 'post',
                            ],'style'=>'margin-right:30px;'
                        ]) ?>
                        <?php
                        if($controller=='package'){
                            echo Html::a('<span class="glyphicon glyphicon-tag panel-icon2"></span> Add item',
                                ['/item/create', 'parent_id' => $id], ['class' => 'mr30']);
                        }
                        else if($controller=='hotel'){
                            echo Html::a('<span class="glyphicon glyphicon-bold"></span> Add hotel from link',['/hotel/grab'], ['class' => 'mr30']);
                        }
                        ?>
                    </div>
                <?php
                }
                elseif(in_array($action,['index','admin','update','show']) && Yii::$app->controller->id!='site')
                {
                    ?>
                    <div class="operations" style="padding: 4px 13px; background-color: #000;">
                        <?= Html::a('<span class="glyphicon glyphicon-list panel-icon2"></span> List', ['index'], ['class' => '','style'=>'margin-right:30px;']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-plus panel-icon2"></span> Create', ['create'], ['class' => '','style'=>'margin-right:30px;']) ?>
                        <?php

                        if($controller=='hotel'){
                            echo Html::a('<span class="glyphicon glyphicon-bold"></span> Add hotel from link',['/hotel/grab'], ['class' => 'mr30']);
                        }
                        ?>
                    </div>
                <?php
                }
                elseif(in_array($action,['create']))
                {
                    ?>
                    <div class="operations" style="padding: 4px 13px; background-color: #000;">
                        <?= Html::a('<span class="glyphicon glyphicon-list panel-icon2"></span> List', ['index'], ['class' => '','style'=>'margin-right:30px;']) ?>
                        <?php

                        if($controller=='hotel'){
                            echo Html::a('<span class="glyphicon glyphicon-bold"></span> Add hotel from link',['/hotel/grab'], ['class' => 'mr30']);
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
         </div>
    </div>
</div>  