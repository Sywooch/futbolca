<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\TinyMce;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\Podcategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="podcategory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category')->dropDownList(Category::getCatForList(), ['prompt' => Yii::t('app', '-- Выберите категою --')]) ?>

    <?= $form->field($model, 'position')->textInput()->hint(Yii::t('app', 'По умолчанию = 0')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php if(!$model->isNewRecord){ ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    <?php } ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6, 'class' => 'myTinyMce']) ?>

    <?= $form->field($model, 'text2')->textarea(['rows' => 6, 'class' => 'myTinyMce']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?=TinyMce::widget()?>
</div>
