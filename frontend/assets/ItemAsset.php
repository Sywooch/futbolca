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
        '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css',
        'css/style.css',
    ];
    public $js = [
        '//code.jquery.com/ui/1.11.4/jquery-ui.js',
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