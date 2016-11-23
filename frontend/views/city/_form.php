<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model frontend\models\City */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="city-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    <?= $form->errorSummary($model); ?>
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

    <?php
    $key = $model->id;
    $url = Url::to(['site/img-delete', 'id' => $key, 'model_name'=>'city']);
    /*$iniImg=false;
    $initialPreviewConfig=[];
    if(!$model->isNewRecord) {
        $iniImg=false;
        if(is_dir("images/city/".$model->id)){
            $imgs=scandir("images/city/".$model->id);
            foreach($imgs as $img){
                if($img!='.' && $img!='..' && $img!=$model->image && $img!='s_'.$model->image){
                    if(strpos($img,'s_' )!== false)
                    {
                        $iniImg[]=Html::img("@web/images/city/".$model->id."/".$img, ['class'=>'file-preview-image', 'alt'=>'']);
                        $initialPreviewConfig[] = ['width' => '80px', 'url' => $url, 'key' => $img];
                    }
                }
            }
        }

    }*/

    $initialPreviewConfig =[];
    if(!$model->isNewRecord && $main_img=$model->image) {
        $iniImg=[Html::img("@web/images/city/".$model->id."/s_".$main_img, ['class'=>'file-preview-image', 'alt'=>''])];
        $url=Url::to(['site/img-delete', 'id' => $model->id, 'model_name'=>'city']);
        $initialPreviewConfig[] = ['width' => '80px', 'url' => $url, 'key' => "s_".$main_img];
    }
    else {
        $iniImg=false;
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

    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
