<?php
/**
 * powered by php-shaman
 * view.php 08.03.2016
 * NewFutbolca
 */

/* @var $this yii\web\View */
/* @var $models frontend\models\Item */
/* @var $model frontend\models\Item */
/* @var $category frontend\models\Category */
/* @var $podcat frontend\models\Podcategory */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = ($podcat->description ? $podcat->description : $podcat->name).(Yii::$app->request->get('page') > 0 ? ' - '.Yii::t('app', 'Страница {page}', ['page' => (int)Yii::$app->request->get('page')]) : '');
$this->params['breadcrumbs'][] = ['label' => $podcat->category0->name, 'url' => ['category/view', 'url' => $podcat->category0->url]];
$this->params['breadcrumbs'][] = $podcat->name;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => ($podcat->keywords ? $podcat->keywords : $this->title).(Yii::$app->request->get('page') > 0 ? ' - '.Yii::t('app', 'Страница {page}', ['page' => (int)Yii::$app->request->get('page')]) : '')
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => ($podcat->keywords ? $podcat->keywords : $this->title).(Yii::$app->request->get('page') > 0 ? ' - '.Yii::t('app', 'Страница {page}', ['page' => (int)Yii::$app->request->get('page')]) : '')
]);
?>

<h1 class="page-title"><?=$podcat->name?></h1>
<div class="clearfix"></div>
<?php if(!Yii::$app->request->get('page')){ ?>
<div style="text-align: justify"><?=$podcat->text2?></div>
<?php } ?>
<div class="clearfix"></div>
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
<div class="clearfix"></div>
<?= \common\lib\LinkPager::widget([
    'pagination' => $pages
]);
?>
<div class="clearfix"></div>
<?php if(!Yii::$app->request->get('page')){ ?>
<div class="small-text">
    <div style="text-align: justify"><?=$podcat->text?></div>
</div>
<?php } ?>

