<?php
/* @var $this yii\web\View */

/* @var $model frontend\models\News */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Блог');
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $this->title
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title
]);

?>
<p style="text-align: left">
    <a href="/" title="Перейти на главную страницу">Главная</a> |
    <a href="http://futboland.com.ua/blog.html" title="Блог">Блог</a>
</p>
<div class="products">

    <?php foreach($models AS $model){ ?>
    <h3><a href="<?=Url::toRoute(['news/view', 'url' => $model->url])?>" title="<?=Html::encode($model->name)?>"><?=$model->name?></a></h3>
    <p style="text-align: justify"><?=strip_tags($model->small)?></p>
    <p style="text-align: right"><a href="<?=Url::toRoute(['news/view', 'url' => $model->url])?>" title="<?=Html::encode($model->name)?>"><?=Yii::t('app', 'Читать польностью')?></a></p>
    <?php } ?>

</div>
