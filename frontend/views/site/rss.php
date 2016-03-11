<?php
/**
 * powered by php-shaman
 * rss.php 11.03.2016
 * NewFutbolca
 */


/* @var $this yii\web\View */
/* @var $item frontend\models\Item */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<?='<?xml version="1.0" encoding="UTF-8" ?>'?>
<rss version="2.0">
    <channel>
        <title>Rss лента товаров <?=Yii::$app->name?></title>
        <link><?=Url::home(true)?></link>
        <description>Список самых лучших футболок от сайта <?=Yii::$app->name?></description>
        <lastBuildDate><?=date("d M Y H:i:s O")?></lastBuildDate>
        <language>ru-RU</language>
        <?php foreach($items AS $item){ ?>
        <item>
            <title><?=Html::encode($item->name)?></title>
            <link><?=Url::toRoute(['item/view', 'url' => $item->url], true)?></link>
            <description><![CDATA[ <?= $item->text ? $item->text : $item->description ?> ]]></description>
            <pubDate><?=date("d M Y H:i:s O")?></pubDate>
            <?php foreach($item->itemCategories AS $category){ ?>
            <category><![CDATA[ <?=$category->category0->name?> ]]></category>
            <?php } ?>
            <?php foreach($item->itemMarkers AS $marker){ ?>
            <tags><![CDATA[ <?=$marker->marker0->name?> ]]></tags>
            <?php } ?>
        </item>
        <?php } ?>
    </channel>
</rss>
