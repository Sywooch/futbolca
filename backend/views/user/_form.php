<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $description backend\models\UserDescription */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'role')->dropDownList(User::listRole()) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'status')->dropDownList(User::listStatus()) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true, 'value' => ''])->hint(Yii::t('app', 'Оставить пустым если не нужно изменять')) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($description, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($description, 'soname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($description, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($description, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($description, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($description, 'country')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($description, 'region')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($description, 'fax')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($description, 'icq')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($description, 'skape')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($description, 'agent')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
