<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Fashion;

/* @var $this yii\web\View */
/* @var $model backend\models\Fashion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fashion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput()->hint(Yii::t('app', 'По умолчанию 0. Цена будет перекрыта ценой основы.')) ?>

    <?= $form->field($model, 'active')->dropDownList(Fashion::listActive()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
