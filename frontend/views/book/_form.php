<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Author;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $author app\models\Author */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->dropDownList(Author::getAllForDropDownList(), ['prompt' => Yii::t('app', '--Выберите автора--')]) ?>

    <div id="newAuthor" style="display: <?=(isset($_POST['Author']['name']) && $_POST['Author']['name']) ? 'block' : 'none'?>;">
        <?= $form->field($author, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Создать') : Yii::t('app', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
