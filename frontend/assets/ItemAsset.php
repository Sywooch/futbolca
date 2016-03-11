<?php
/**
 * powered by php-shaman
 * ItemAsset.php 10.03.2016
 * NewFutbolca
 */

namespace frontend\assets;


class ItemAsset extends AppAsset
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery-ui/jquery-ui.min.css',
        'css/style.css',
    ];
    public $js = [
        'js/jquery-ui.min.js',
        'js/datepicker-ru.js',
//        'js/alight_0.12.last.min.js',
//        'js/alight/ctrl.item.js',
        'js/home.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}