<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
use iutbay\yii2kcfinder\KCFinder;

/* @var $this yii\web\View */
/* @var $model frontend\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

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

    <?php //echo $form->field($model, 'image')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'category')->dropDownList(["0"=>"General","1"=>"Explore UAE with us", "2"=>"Destinations of your interest"],[]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
