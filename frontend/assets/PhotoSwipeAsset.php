<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class PhotoSwipeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //public $sourcePath = '@frontend\assets';
    public $css = [
        'photoswipe/photoswipe.css',
        'photoswipe/photoswipe-default-skin/default-skin.css',
    ];
    public $js = [
        'photoswipe/photoswipe.min.js',
        'photoswipe/photoswipe-ui-default.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
