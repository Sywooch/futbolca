<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Individual */

$this->title = Yii::t('app', 'Create Individual');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Individuals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="individual-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
