<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\TinyMce;
use backend\models\Element;
use backend\models\Item;

/* @var $this yii\web\View */
/* @var $model backend\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($model, 'element')->dropDownList(Element::getCatForList(), ['prompt' => Yii::t('app', '-- Выберите основу -- ')]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'position')->textInput()->hint(Yii::t('app', 'По умолчанию = 0. В самом низу = 0')) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?php if(!$model->isNewRecord){ ?>
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'active')->dropDownList(Item::listHome()) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'home')->dropDownList(Item::listHome()) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'toppx')->textInput() ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'leftpx')->textInput() ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'resizeH')->textInput() ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'resizeW')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'text')->textarea(['rows' => 6, 'class' => 'myTinyMce']) ?>

    <?php for($i = 0; $i < 5; $i++){ ?>
    <?= $form->field($model, 'image[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?=TinyMce::widget()?>

</div>
