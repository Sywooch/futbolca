<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Element */
/* @var $fashion backend\models\Fashion */

$this->title = Yii::t('app', 'Create Model');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'fashion' => $fashion,
    ]) ?>

</div>
