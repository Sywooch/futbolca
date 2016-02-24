<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Paying */

$this->title = Yii::t('app', 'Create Paying');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paying-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
