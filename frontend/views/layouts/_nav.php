<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

if($controller=='page' && $action=="view" && Yii::$app->request->get('id')==1) $about_active=true; else $about_active=false;

NavBar::begin([
    'brandLabel' => "<div class='logo_wrap  logo_wrap_index js_logo_wrap'></div>",
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'mynavbar navbar-fixed-top',
    ],
]);
$menuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
    ['label' => 'About us', 'url' => ['/page/1'], 'active'=>$about_active],
    ['label' => 'Explore UAE', 'url' => ['/site/explore']],
    ['label' => 'Destinations', 'url' => ['/destination/show']],
    ['label' => 'Contact', 'url' => ['/site/contact']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>
