<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Fashion */

$this->title = Yii::t('app', 'Create Fashion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fashions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fashion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
