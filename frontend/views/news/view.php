<?php
/**
 * powered by php-shaman
 * view.php 09.03.2016
 * NewFutbolca
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\News */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = ($model->description ? $model->description : $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Блог'), 'url' => ['news/index']];
$this->params['breadcrumbs'][] = $model->name;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => ($model->keywords ? $model->keywords : $this->title)
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => ($model->keywords ? $model->keywords : $this->title)
]);
?>
<br>
<h2><?=$model->name?></h2>
<div style="text-align: justify; margin: 10px 0 20px 0;"><?=$model->text?></div>
<p style="text-align: right"><a href="<?=Url::toRoute(['news/index'])?>" title="<?=Html::encode(Yii::t('app', 'Назад'))?>"><?=Yii::t('app', 'Назад')?></a></p>

