<?php
/**
 * powered by php-shaman
 * sitemap.php 11.03.2016
 * NewFutbolca
 */

/* @var $this yii\web\View */
/* @var $category frontend\models\Category */
/* @var $tag frontend\models\Marker */
/* @var $item frontend\models\Item */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<?='<?xml version="1.0" encoding="UTF-8"?>'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?=Url::home(true)?></loc>
        <lastmod><?=date("Y-m-d")?></lastmod>
        <changefreq>hourly</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc><?=Url::toRoute(['individual/index'], true)?></loc>
        <lastmod><?=date("Y-m-d")?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <?php foreach($categories AS $category){ ?>
    <url>
        <loc><?=Url::toRoute(['category/view', 'url' => $category->url], true)?></loc>
        <lastmod><?=date("Y-m-d")?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <?php } ?>
    <?php foreach($tags AS $tag){ ?>
        <url>
            <loc><?=Url::toRoute(['tags/view', 'url' => $tag->url], true)?></loc>
            <lastmod><?=date("Y-m-d")?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    <?php } ?>
    <?php foreach($items AS $item){ ?>
        <url>
            <loc><?=Url::toRoute(['item/view', 'url' => $item->url], true)?></loc>
            <lastmod><?=date("Y-m-d")?></lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    <?php } ?>
</urlset>
