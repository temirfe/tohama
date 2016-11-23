<?php
use yii\helpers\Html;
?>
<div class="admpanel_top">
      <div class="admpanel-title">
          <div class="admpanel-title-wrapper">Admin panel<span class="openclose js_openclose">Hide - </span></div>
      </div>
      <div class="admpanel-content js_admpanel-content">
      	<div class="top_admpanel_wrapper">
            <div class="operations">
                <div><span class='panel-icon glyphicon glyphicon-barcode'></span><?=Html::a('Tовары', ['/product/admin'], ['id'=>'product_adm']); ?></div>
             </div>
             <div class="clear"></div>
                <?php
                $id='';
                $request=Yii::$app->request;
                if($param=$request->get('param')){
                    $pages = $dao->createCommand("SELECT id,url_address FROM Page")->queryAll();
                    foreach($pages as $page){
                        if($page['url_address']==$param) {$id=$page['id'];}
                    }
                }
                else {$id=$request->get('id');}
                $action=Yii::$app->controller->action->id;
                if($action=='view' && $id)
                {
                    ?>
                    <div class="operations_title">Operations</div>
                    <div class="operations" style="padding: 4px 13px 0;">
                        <?= Html::a('<span class="glyphicon glyphicon-list panel-icon2"></span> List', ['index'], ['class' => '','style'=>'margin-right:30px;']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-plus panel-icon2"></span> Create', ['create'], ['class' => '','style'=>'margin-right:30px;']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-pencil panel-icon2"></span> Update', ['update', 'id' => $id], ['class' => '','style'=>'margin-right:30px;']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-remove panel-icon2"></span> Delete', ['delete', 'id' => $id], [
                            'data' => [
                                'confirm' => 'Are you sure you want to delete?',
                                'method' => 'post',
                            ],'style'=>'margin-right:30px;'
                        ]) ?>
                    </div>
                <?php
                }
                elseif(in_array($action,['index','admin','update']) && Yii::$app->controller->id!='site')
                {
                    ?>
                    <div class="operations_title">Operations</div>
                    <div class="operations" style="padding: 4px 13px 0;">
                        <?= Html::a('<span class="glyphicon glyphicon-list panel-icon2"></span> List', ['index'], ['class' => '','style'=>'margin-right:30px;']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-plus panel-icon2"></span> Create', ['create'], ['class' => '','style'=>'margin-right:30px;']) ?>
                    </div>
                <?php
                }
                ?>
         </div>
    </div>
</div>  