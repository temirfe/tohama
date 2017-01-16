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
$controller=Yii::$app->controller->id;
if($controller=='page') $pages_active="active";
else if($controller=='package') $package_active="active";
else if($controller=='item') $item_active="active";
else if($controller=='destination') $dest_active="active";
else if($controller=='user') $user_active="active";
else if($controller=='hotel') $hotel_active="active";
else if($controller=='city') $city_active="active";
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
                <div class="<?=$hotel_active?>"><span class='panel-icon glyphicon glyphicon-home'></span><?=Html::a('Hotels', ['/hotel/index']); ?></div>
                <div class="<?=$city_active?>"><span class='panel-icon glyphicon glyphicon-map-marker'></span><?=Html::a('Cities', ['/city/index']); ?></div>
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
                elseif(in_array($action,['index','admin','update']) && Yii::$app->controller->id!='site')
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