<?php
/**
 * powered by php-shaman
 * HomeCat.php 08.03.2016
 * NewFutbolca
 */

/* @var $model \frontend\models\News */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<?php foreach($categories AS $url => $name){ ?>
<li><a href="<?=Url::toRoute(['category/view', 'url' => $url])?>" title="<?=Html::encode($name['title'])?>"><?=$name['name']?></a></li>
<?php } ?>
