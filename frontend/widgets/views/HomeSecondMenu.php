<?php
/**
 * powered by php-shaman
 * HomeSecondMenu.php 08.03.2016
 * NewFutbolca
 */

/* @var $model \frontend\models\News */

use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="menu">
    <ul>
        <li><a href="<?=Url::home(true)?>" title="Главная страница">Главная страница</a></li>
        <?php foreach($urls AS $name => $url){ ?>
            <li><a href="<?=Url::toRoute(['page/view', 'url' => $url])?>" title="<?=Html::encode($name)?>"><?=$name?></a></li>
        <?php } ?>
    </ul>
    <span class="cl"></span>
    <span class="cr"></span>
</div>
