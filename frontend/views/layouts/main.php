<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\models\HotelSearch;
use yii\bootstrap\Modal;

AppAsset::register($this);
$controller=Yii::$app->controller->id;
$action=Yii::$app->controller->action->id;

if(!isset($user)) $user=Yii::$app->user;
if(!isset($isGuest)) $isGuest=$user->isGuest;
if(!isset($identity)) $identity=$user->identity;
if(!isset($user_id) && $identity) $user_id=$identity->id; else $user_id='';
if(!isset($user_name) && $identity) $user_name=$identity->username; else $user_name='';
if(!isset($user_role) && $identity) $user_role=$identity->role; else $user_role='';
if(!isset($dao)) $dao=Yii::$app->db;
if($controller=="site" && $action=="index")
{
    $banner_title=''; $banner_description='';
    $banner = $dao->createCommand("SELECT * FROM banner ORDER BY id DESC")->queryOne();
    if($banner){
        if($banner['link']) {
            $banner_title=Html::a($banner['title'],$banner['link'],['class'=>'no_underline']);
            $banner_description=Html::a($banner['description'],$banner['link'],['class'=>'no_underline']);
        }
        else {$banner_title=$banner['title']; $banner_description=$banner['description'];}
    }
}
else {$banner=['id'=>'','image'=>''];}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/css/swiper.min.css">
    <link rel="shortcut icon" href="/images/favicon2.ico" type="image/x-icon">
    <link rel="icon" href="/images/favicon2.ico" type="image/x-icon">
    <style type="text/css">
        .slider{background:rgba(0, 0, 0, 0) url("/images/banner/<?=$banner['id']?>/<?=$banner['image']?>") no-repeat scroll 0 center / 100% auto;}
    </style>
</head>
<body data-spy="scroll" data-target="#myScrollspy" data-offset="140" id="top">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    if(!$isGuest && $user_role=='admin'){include_once('_adminpanel.php');}
    //elseif(!$isGuest && $user_role=='Moderator'){include_once('_moderpanel.php');}
    //elseif(!$isGuest && $user_role=='ContentManager'){include_once('_cmanagerpanel.php');}
    include_once('_nav.php');
    ?>

    <?php
        if($controller=="site" && $action=="index"){
            ?>
            <div class='slider rel'>
                <div class="slider_title abs">
                    <h1 class="mt0"><?=$banner_title?></h1>
                    <?=$banner_description?>
                </div>
                <div class="search_container">
                    <div class="abs fhwrapper">
                        <span class="hotels_tab search_tab js_hotels_tab">
                            <i class="glyphicon glyphicon-lamp hotel_icon"></i>
                            Hotels
                            <span class="tab_border tab_border_hotel"></span>
                        </span>
                        <span class="flights_tab search_tab js_flights_tab">
                            <i class="plane_icon"></i>
                            Flights
                            <span class="tab_border tab_border_flights"></span>
                        </span>
                        <span class="white_tab search_tab ">
                        </span>
                        <?=$this->render('/hotel/_search', ['model' => new HotelSearch(), 'index'=>true]);?>
                        <div class="flights_wrap js_flights_wrap hiddeniraak">
                            <!-- If you want the widget to support IE8, please include the following snippet: -->
                            <!--[if lt IE 9]><script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/es5-shim/4.1.0/es5-shim.js"></script><script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script><![endif]--><!--[if gte IE 9]><!--><script src="//code.jquery.com/jquery-2.1.1.min.js"></script><!--<![endif]-->
                            <!-- IE8 snippet end -->

                            <script type="text/javascript" src="http://flights.tohamatravel.com/scripts/widget/sswidget.load.v1.min.js?product=flights&type=medium&language=en-GB&origin=DXBA"></script>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    ?>

    <div class="container">
        <?php /*= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])  */?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="pull-left mr20">&copy; Tohama Travel & Tourism LLC <?= date('Y') ?></div>
        <div class="ml20">
            <?php
            if (Yii::$app->user->isGuest) {
                echo Html::a('Customer Login',['/site/login'],['class'=>'gray5 font12']);
            } else {
                echo Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm();
            }
            ?>
        </div>
    </div>
</footer>
<a href="#" class="scrollToTop"><span class="glyphicon glyphicon-arrow-up"></span></a>
<?php $this->endBody() ?>
<?php
if(Yii::$app->request->serverName!='tohama.loc' && ($isGuest || $user_role=='user')){
    ?>
    <!-- BEGIN JIVOSITE CODE {literal} -->
    <script type='text/javascript'>
        (function(){ var widget_id = 'qPuZmTVXvA';var d=document;var w=window;function l(){
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
    <!-- {/literal} END JIVOSITE CODE -->
<?php
}
?>
<?php
$modal = Modal::begin([
    'id' => 'terms-modal',
    'header' => Html::tag('h4', Yii::t('app', 'Hotel Terms & Conditions'), ['class' => 'modal-title']),
]);
echo "<div class='js_terms_here terms terms_modal'></div>";
$modal::end();
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/js/swiper.min.js"></script>
<script type="text/javascript">
    //swiper
    var mySwiper = new Swiper ('.swiper-container', {
        // Optional parameters
        loop: true,
        freeMode: true,
        spaceBetween: 30,
        slidesPerView: 3,
        autoplay: 2000
    });
</script>
</body>
</html>
<?php $this->endPage() ?>