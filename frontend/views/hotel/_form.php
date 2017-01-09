<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model frontend\models\Hotel */
/* @var $form yii\widgets\ActiveForm */
$dao=Yii::$app->db;
$country_query = $dao->createCommand("SELECT id,title FROM country")->queryAll();
$countries=ArrayHelper::map($country_query,'id','title');

if($model->isNewRecord){$model->country_id=234;} //UAE by preselected

if($model->country_id){
    $city_query = $dao->createCommand("SELECT id,title FROM city WHERE country_id='{$model->country_id}'")->queryAll();
    $cities=ArrayHelper::map($city_query,'id','title');
}
else $cities=[];
?>

<div class="hotel-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'custom',
        'clientOptions'=>[
            'allowedContent'=>true,
            //'extraAllowedContent'=>'span(*);div(*)[*]{*};h2(*)',
            'enterMode' => 2,
            'forceEnterMode'=>false,
            'shiftEnterMode'=>1,
            'toolbar'=>[ //toolbar names can be found here: http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Toolbar
                ['name'=>'document','items'=>['Source']],
                ['name'=>'basicstyles','items'=>['Bold','Italic','Underline','Strike','-','TextColor','BGColor','-','RemoveFormat']],
                ['name'=>'Clipboard','items'=>['Paste','PasteText','PasteFromWord']],
                ['name'=>'insert','items'=>['Image','Table','HorizontalRule']],
                ['name'=>'paragraph','items'=>['NumberedList','BulletedList','-','Outdent','Indent']],
                ['name'=>'links','items'=>['Link','Unlink']],
                ['name'=>'styles','items'=>['Styles','Format','Font','FontSize']],
                ['name'=>'tools','items'=>['Maximize']],
            ]
        ]
    ]) ?>
    <?= $form->field($model, 'country_id')->dropDownList($countries,['prompt'=>'Select..']); ?>
    <?= $form->field($model, 'city_id')->dropDownList($cities,['prompt'=>'Select..']); ?>

    <?= $form->field($model, 'neighborhood')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?php
    $key = $model->id;
    $model_name='hotel';
    $url = Url::to(['site/img-delete', 'id' => $key, 'model_name'=>$model_name]);

    $initialPreviewConfig =[];
    $iniImg=false;
    if(!$model->isNewRecord && $main_img=$model->image) {
        $iniImg=[Html::img("@web/images/{$model_name}/".$model->id."/s_".$main_img, ['class'=>'file-preview-image', 'alt'=>''])];
        $url=Url::to(['site/img-delete', 'id' => $model->id, 'model_name'=>$model_name]);
        $initialPreviewConfig[] = ['width' => '80px', 'url' => $url, 'key' => "s_".$main_img];
    }
    elseif($model->thumb) {
        $iniImg=[Html::img($model->thumb, ['class'=>'file-preview-image', 'alt'=>''])];
        $url=Url::to(['site/img-delete', 'id' => $model->id, 'model_name'=>$model_name]);
        $initialPreviewConfig[] = ['width' => '80px', 'url' => $url, 'key' => ""];
    }

    echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'initialPreview'=>$iniImg,
            'previewFileType' => 'any',
            'uploadUrl' => Url::to(['/city/img-upload','id'=>$model->id]),
            'initialPreviewConfig' => $initialPreviewConfig,
        ],
    ]);
    if(!$model->imglinks){
        $iniImg2=false;
        $initialPreviewConfig2=[];
        if(!$model->isNewRecord) {
            if(is_dir("images/{$model_name}/".$model->id)){
                $imgs=scandir("images/{$model_name}/".$model->id);
                foreach($imgs as $img){
                    if($img!='.' && $img!='..' && $img!=$model->image && $img!='s_'.$model->image){
                        if(strpos($img,'s_' )!== false)
                        {
                            $iniImg2[]=Html::img("@web/images/{$model_name}/".$model->id."/".$img, ['class'=>'file-preview-image', 'alt'=>'']);
                            $initialPreviewConfig2[] = ['width' => '80px', 'url' => $url, 'key' => $img];
                        }
                    }
                }
            }
        }
        echo $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*','multiple'=>true],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'overwriteInitial'=>false,
                'initialPreview'=>$iniImg2,
                'previewFileType' => 'any',
                'uploadUrl' => Url::to(['/site/img-upload','id'=>$model->id]),
                'initialPreviewConfig' => $initialPreviewConfig2,

            ],
        ]);

    }
    ?>

    <?= $form->field($model, 'latlong')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stars')->dropDownList(['0','1','2','3','4','5','6','7'],['prompt'=>'Select..']); ?>

    <div class="js_skus">
        <?php
        if($model->sku){
            $skus=explode(';;',$model->sku);
            foreach($skus as $sku){
                echo $form->field($model, "skuitem[]")->textInput(['maxlength' => true,'value'=>htmlspecialchars($sku,ENT_QUOTES)]);
            }
        }
        else{
            echo $form->field($model, "skuitem[]")->textInput(['maxlength' => true]);
        }
        ?>
    </div>
    <?=Html::a(Yii::t('app','Add more SKU (Excel name)'),'#',['class'=>'js_add_sku mb20 iblock']);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="js_sku_form hidden"><?=$form->field($model, 'skuitem[]')->textInput(['maxlength' => true])?></div>