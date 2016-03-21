<?php
/**
 * powered by php-shaman
 * ConvertAsset.php 21.03.2016
 * NewFutbolca
 */

namespace frontend\assets;

use yii\web\AssetBundle;


class ConvertAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css',
        'css/bootstrap/css/bootstrap.min.css',
        'css/site.css',
    ];
    public $js = [
        '//code.jquery.com/ui/1.11.4/jquery-ui.js',
        'css/bootstrap/js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}