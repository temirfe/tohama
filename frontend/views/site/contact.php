<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-5">
            <p>
                If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
            </p>

            <div class="row">
                <div class="col-lg-12">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">
            Tohama Travel and Tourism LLC<br />
            Office 901<br />
            Al Kharbash Tower<br />
            Dubia, UAE<br />
            Tel: + 971 4 359 9015<br />
            Fax: +971 4 359 9014<br />
            Email: <a href="mailto:info@tohamatravel.com">info@tohamatravel.com</a>

        </div>
    </div>


</div>
