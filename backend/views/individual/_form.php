<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Individual;

/* @var $this yii\web\View */
/* @var $model backend\models\Individual */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('/admin/tinymce/jquery.maskedinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$js = <<<JS
    jQuery(function($){
        $("#individual-phone").mask("+38(099)999-99-99");
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-phone-ms');
?>

<div class="individual-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(Individual::listStatus()) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?php if($model->isNewRecord){ ?>
        <?php for($i = 0; $i < 4; $i++){ ?>
        <?= $form->field($model, 'image[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
        <?php } ?>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
