<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Podcategory */

$this->title = Yii::t('app', 'Create Podcategory');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Podcategories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="podcategory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
