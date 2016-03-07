<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'data_start') ?>

    <?= $form->field($model, 'data_finish') ?>

    <?= $form->field($model, 'user') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'soname') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'adress') ?>

    <?php // echo $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'payment') ?>

    <?php // echo $form->field($model, 'delivery') ?>

    <?php // echo $form->field($model, 'agent') ?>

    <?php // echo $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'icq') ?>

    <?php // echo $form->field($model, 'skape') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'coment_admin') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
