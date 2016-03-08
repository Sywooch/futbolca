<?php
/**
 * powered by php-shaman
 * HomeNews.php 08.03.2016
 * NewFutbolca
 */

/* @var $model \frontend\models\News */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="side-box">
    <div class="side-box-title"><?=Yii::t('app', 'Последнее из блогов')?></div>
    <div class="side-box-top"></div>
    <div class="side-box-content">
        <div class="item">
            <a href="<?=Url::toRoute(['news/view', 'url' => $model->url])?>" class="item-title" title="<?=Html::encode($model->name)?>"><?=$model->name?></a>
            <p><?=$model->small?></p>
        </div>
        <a href="<?=Url::toRoute('news/index')?>" class="more" title="<?=Html::encode(Yii::t('app', 'Перейти в блог'))?>"><?=Yii::t('app', 'Перейти в блог')?></a>
    </div>
    <div class="side-box-bot"></div>
</div>
