<?php

/* @var $this yii\web\View */
/* @var $models frontend\models\Item */
/* @var $model frontend\models\Item */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Settings;

$this->title = Settings::getSettings('sate_keywords') ? Settings::getSettings('sate_keywords') : Yii::t('app', 'МИР ФУТБОЛОК - УКРАИНА');
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => Settings::getSettings('sate_des') ? Settings::getSettings('sate_des') : Yii::t('app', 'Прикольные футболки на заказ - купить в интернет-магазине Futboland.com.ua. Майки с любимыми кумирами')
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => Settings::getSettings('sate_des') ? Settings::getSettings('sate_des') : Yii::t('app', 'Прикольные футболки на заказ - купить в интернет-магазине Futboland.com.ua. Майки с любимыми кумирами')
]);
?>

<h1 class="page-title"><?=Yii::t('app', 'МИР ФУТБОЛОК - УКРАИНА')?></h1>
<p></p>
<?php foreach($models AS $model){ ?>
<div class="prod-box fl">
    <a href="<?=Url::toRoute(['item/view', 'url' => $model->url])?>" class="prod-title" title="<?=Html::encode($model->name)?>"><?=$model->name?></a>
    <div class="img-wrap"><a href="<?=Url::toRoute(['item/view', 'url' => $model->url])?>" title="<?=Html::encode($model->name)?>"><img src="<?=$model->getImageFromItem()?>" alt="<?=Html::encode($model->name)?>"></a></div>
    <div class="prod-info">
        <a href="<?=Url::toRoute(['item/view', 'url' => $model->url])?>" class="prod-select" title="<?=Html::encode(Yii::t('app', 'Выбрать цвет и размер'))?>"><?=Yii::t('app', 'Выбрать цвет и размер')?></a>
        <span class="price"><?=$model->getAllPrice()?> грн.</span>
    </div>
    <div class="prod-box-top"></div>
    <div class="prod-box-bot"></div>
</div>
<?php } ?>
