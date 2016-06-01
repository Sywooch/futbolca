<?php
/**
 * powered by php-shaman
 * sitemap.php 11.03.2016
 * NewFutbolca
 */

/* @var $this yii\web\View */
/* @var $category frontend\models\Category */
/* @var $categories[] frontend\models\Category */
/* @var $tag frontend\models\Marker */
/* @var $item frontend\models\Item */
/* @var $items[] frontend\models\Item */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Settings;
use yii\helpers\ArrayHelper;
use backend\models\Proportion;

?>
<?='<?xml version="1.0" encoding="UTF-8"?>'?>
<?='<!DOCTYPE yml_catalog SYSTEM "shops.dtd">'?>
<yml_catalog date="<?=date("Y-m-d H:i")?>">
    <shop>
        <name><?=Html::encode(Settings::getSettings('sate_name'))?></name>
        <company><?=Html::encode(Settings::getSettings('sate_name'))?></company>
        <url><?=Url::home(true)?></url>
        <currencies>
            <currency id="UAH" rate="1"/>
        </currencies>
        <categories>
            <?php foreach($categories AS $category){ ?>
            <category id="<?=$category->id?>"><?=Html::encode($category->name)?></category>
            <?php } ?>
        </categories>
        <cpa>1</cpa>
        <offers>
            <?php foreach($items AS $item){ ?>
            <?php
            $sizeId = ArrayHelper::map($item->element0->elementSizes, 'size', 'size');
            $sizes = Proportion::find()->where(['in', 'id', $sizeId])->orderBy("id asc")->all();
            ?>
            <?php if(sizeof($sizes) > 0){ ?>
            <?php foreach($sizes AS $size){ ?>
            <offer id="<?=$item->id?>" available="true" bid="50" cbid="50" group_id="<?=$item->id?>">
                <url><?=Url::toRoute(['item/view', 'url' => $item->url], true)?></url>
                <price><?=$item->getAllPrice()?></price>
                <currencyId>UAH</currencyId>
                <categoryId><?=Html::encode(isset($item->itemCategories[0]) ? $item->itemCategories[0]->category : 0)?></categoryId>
                <?php if(isset($item->itemWatermarks) && sizeof($item->itemWatermarks) > 0){ ?>
                <?php foreach($item->itemWatermarks AS $watermarks){ ?>
                <picture><?=rtrim(Url::home(true), '/')?><?=Html::encode($item->getImageFromItem($watermarks->id))?></picture>
                <?php } ?>
                <?php } ?>
                <store>true</store>
                <delivery>true</delivery>

                <name><?=Html::encode($item->name)?></name>
                <vendor><?=Html::encode(Settings::getSettings('sate_name'))?></vendor>
                <model><?=Html::encode($item->element0->fashion0->name)?></model>
                <description><?=Html::encode($item->text ? $item->text : $item->description)?></description>
                <age>0</age>
                <param name="Размер" unit="INT"><?=Html::encode($size->name)?></param>
            </offer>
            <?php } ?>
            <?php }else{ ?>
            <offer id="<?=$item->id?>" available="true" bid="50" cbid="50">
                <url><?=Url::toRoute(['item/view', 'url' => $item->url], true)?></url>
                <price><?=$item->getAllPrice()?></price>
                <currencyId>UAH</currencyId>
                <categoryId><?=Html::encode(isset($item->itemCategories[0]) ? $item->itemCategories[0]->id : 0)?></categoryId>
                <?php if(isset($item->itemWatermarks) && sizeof($item->itemWatermarks) > 0){ ?>
                    <?php foreach($item->itemWatermarks AS $watermarks){ ?>
                        <picture><?=rtrim(Url::home(true), '/')?><?=Html::encode($item->getImageFromItem($watermarks->id))?></picture>
                    <?php } ?>
                <?php } ?>
                <store>true</store>
                <delivery>true</delivery>
                <name><?=Html::encode($item->name)?></name>
                <vendor><?=Html::encode(Settings::getSettings('sate_name'))?></vendor>
                <model><?=Html::encode($item->element0->fashion0->name)?></model>
                <description><?=Html::encode($item->text ? $item->text : $item->description)?></description>
                <age>0</age>
            </offer>
            <?php } ?>
            <?php } ?>
        </offers>
    </shop>
</yml_catalog>
