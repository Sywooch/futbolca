<?php
/**
 * powered by php-shaman
 * block.php 10.03.2016
 * NewFutbolca
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\Item */
/* @var $item frontend\models\Item */
/* @var $element frontend\models\Element */
/* @var $sizeValue frontend\models\Proportion */
/* @var $watermark frontend\models\ItemWatermark */
/* @var $fashion frontend\models\Fashion */
/* @var $elementItem frontend\models\Element */

\frontend\assets\ItemAsset::register($this);

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Item;
use yii\helpers\Json;

?>
<h1 class="page-title"><?=$model->name?></h1>
<input type="hidden" name="currentElement" value="<?=$elementItem->id?>" id="currentElementId">
<div class="product-img">
    <img src="<?=$model->getImageFromItem($currentWatermark, $elementItem)?>" alt="<?=Html::encode($model->name)?>" id="fullImage">
    <p></p>
    <span class="detail-title"><?=Yii::t('app', 'Цвет основы')?></span>
    <ul class="product-img-list">
        <?php if($model->element0->fashion == $currentFashion){ ?>
        <li><img class="imgElementn" src="<?=$elementItem->getImageLink()?>" onclick="changes.element('<?=(int)$elementItem->id?>');" title="<?=Html::encode($model->element0->name)?>" alt="<?=Html::encode($model->element0->name)?>"></li>
        <?php } ?>
        <?php foreach($elements AS $keyE => $element){ ?>
            <li><img class="imgElementn" src="<?=$element->getImageLink()?>" onclick="changes.element('<?=(int)$element->id?>');" title="<?=Html::encode($element->name)?>" alt="<?=Html::encode($element->name)?>"></li>
        <?php } ?>
    </ul>
</div>
<div class="product-detail">
    <span class="detail-title"><strong><?=Yii::t('app', 'Модель одежды')?></strong></span>
    <label for="fashion-<?=(int)$model->element0->fashion?>" ><input type="radio" name="fashion" onclick="changes.fashion('<?=(int)$model->element0->fashion?>');" class="labelFashion"<?=$currentFashion == (int)(int)$model->element0->fashion ? ' checked' : ''?> value="<?=(int)$model->element0->fashion?>" id="fashion-<?=(int)$model->element0->fashion?>"><?=$model->element0->fashion0->name?></label>
    <?php foreach($fashions AS $fashion){ ?>
        <label for="fashion-<?=(int)$fashion->id?>" ><input type="radio" name="fashion" onclick="changes.fashion('<?=(int)$fashion->id?>');" class="labelFashion"<?=$currentFashion == (int)$fashion->id ? ' checked' : ''?> value="<?=(int)$fashion->id?>" id="fashion-<?=(int)$fashion->id?>"><?=$fashion->name?></label>
    <?php } ?>
    <?php if(sizeof($model->itemWatermarks) > 1){ ?>
        <span class="detail-title"><strong><?=Yii::t('app', 'Принт')?></strong></span>
        <div class="prints">
            <?php foreach($model->itemWatermarks AS $keyW => $watermark){ ?>
                <?php if($keyW > 0){ ?><br><?php } ?>
                <img src="<?=$watermark->getImageUrl(true)?>" onclick="changes.watermark('<?=$watermark->id?>');" title="<?=Html::encode(Yii::t('app', 'Кликните для выбора принта'))?>" alt="<?=Html::encode(Yii::t('app', 'Принт {print} вариант {variant}', ['print' => $model->name, 'variant' => ($keyW + 1)]))?>" class="print_mini">
            <?php } ?>
        </div>
    <?php } ?>
    <span class="detail-title"><strong><?=Yii::t('app', 'Размер')?></strong> <br><a href="<?=Url::toRoute(['page/view', 'url' => 'sizes'])?>" title="<?=Html::encode(Yii::t('app', 'Таблица размеров'))?>"><strong><?=Yii::t('app', 'Таблица размеров')?></strong></a></span>
    <div class="prodsize">
        <?php foreach($size AS $sizeValue){ ?>
            <label for="size-id-<?=$sizeValue->id?>"><span><?=$sizeValue->name?></span><input type="radio" onclick="changes.size('<?=(int)$sizeValue->id?>');" name="sizeItem"<?=$currentSize == (int)$sizeValue->id ? ' checked' : ''?> value="<?=$sizeValue->name?>" id="size-id-<?=$sizeValue->id?>"></label>
        <?php } ?>
    </div>
    <span class="detail-title"><?=Yii::t('app', 'Цена')?>: <strong id="price_tovar" class="price1"><?=(int)$model->getAllPrice($elementItem)?></strong> <?=Yii::t('app', 'грн')?>.</span>
    <input type="text"  value="<?=(int)$currentCount?>" onblur="changes.count(this);" onkeyup="changes.count(this);" class="text-field" name="count_tovar">
    <input type="button" value="<?=Yii::t('app', 'В корзину')?>" class="submit-btn" id="inCartClick">
</div>
