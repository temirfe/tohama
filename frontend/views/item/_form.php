<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model frontend\models\PackageItem */
/* @var $form yii\widgets\ActiveForm */
$parent_id=Yii::$app->request->get('parent_id');
if($parent_id) $model->parent_id=$parent_id;
?>

<div class="package-item-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'parent_id')->dropDownList($packages,['prompt'=>'Select..']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'custom',
        'clientOptions'=>[
            'allowedContent'=>true,
            'filebrowserUploadUrl' => '/site/editor-upload',
            'filebrowserBrowseUrl' => '/site/editor-browse',
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
                ['name'=>'styles','items'=>['Styles','Format','Font','FontSize','TextColor']],
                ['name'=>'tools','items'=>['Maximize']],
            ]
        ]
    ]) ?>

    <?php
    $key = $model->id;
    $url = Url::to(['site/img-delete', 'id' => $key, 'model_name'=>'package']);
    $iniImg=false;
    $initialPreviewConfig=[];
    if(!$model->isNewRecord) {
        $iniImg=false;
        if(is_dir("images/item/".$model->id)){
            $imgs=scandir("images/item/".$model->id);
            foreach($imgs as $img){
                if($img!='.' && $img!='..' && $img!=$model->image && $img!='s_'.$model->image){
                    if(strpos($img,'s_' )!== false)
                    {
                        $iniImg[]=Html::img("@web/images/item/".$model->id."/".$img, ['class'=>'file-preview-image', 'alt'=>'']);
                        $initialPreviewConfig[] = ['width' => '80px', 'url' => $url, 'key' => $img];
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
            'initialPreview'=>$iniImg,
            'previewFileType' => 'any',
            'uploadUrl' => Url::to(['/site/img-upload','id'=>$model->id]),
            'initialPreviewConfig' => $initialPreviewConfig,

        ],
    ]);
    ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
