<?php
/**
 * powered by php-shaman
 * view.php 09.03.2016
 * NewFutbolca
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\Page  */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = ($model->keywords ? $model->keywords : $model->name);
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заказы'), 'url' => ['user/orders']];
$this->params['breadcrumbs'][] = $model->name;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => ($model->description ? $model->description : $this->title)
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => ($model->description ? $model->description : $this->title)
]);

?>
<h1 class="page-title"><?=$model->name?></h1>
<div style="text-align: justify">
    <?=$model->text?>
</div>
