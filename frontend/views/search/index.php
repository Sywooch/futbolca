<?php
/**
 * powered by php-shaman
 * index.php 09.03.2016
 * NewFutbolca
 */

/* @var $this yii\web\View */
/* @var $models frontend\models\Item */
/* @var $model frontend\models\Item */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = (Yii::t('app', 'Поиск по запросу "{search}"', ['search' => $search])).(Yii::$app->request->get('page') > 0 ? ' - '.Yii::t('app', 'Страница {page}', ['page' => (int)Yii::$app->request->get('page')]) : '');
//$this->params['breadcrumbs'][] = ['label' => $podcat->category0->name, 'url' => ['category/view', 'url' => $podcat->category0->url]];
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $this->title.(Yii::$app->request->get('page') > 0 ? ' - '.Yii::t('app', 'Страница {page}', ['page' => (int)Yii::$app->request->get('page')]) : '')
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title.(Yii::$app->request->get('page') > 0 ? ' - '.Yii::t('app', 'Страница {page}', ['page' => (int)Yii::$app->request->get('page')]) : '')
]);
?>

<h1 class="page-title"><?=Yii::t('app', 'Поиск по запросу "{search}"', ['search' => $search])?></h1>
<div>
<form action="<?=Url::toRoute(['search/index'])?>" method="get" accept-charset="utf-8">
    <input id="seach_text_id_full" type="text" name="seach_text" value="<?=Yii::$app->request->get('seach_text')?>" size="80" autocomplete="off" placeholder="Введите слово для поиска">
    <input type="submit" value="Искать" style="text-align: center; width: 75px; height: 25px;" />
</form>
</div>
<div class="clearfix"></div>
<p></p>
<?php if(sizeof($models) > 0){ ?>
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
<?php }else{ ?>
    <p><?=Yii::t('app', 'Ничего не найдено')?></p>
<?php } ?>
<div class="clearfix"></div>
