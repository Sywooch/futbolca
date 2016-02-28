<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\HomePage */

$this->title = Yii::t('app', 'Create Home Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Home Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
