<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Paying */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
    $('#delete-img-f').click(function(){
        $.get("/admin/paying/deleteimg/?id={$model->id}", {}, function(){
            $('.forimg').hide();
        });
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-img-delete');
?>
<div class="paying-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?php if($model->img){ ?>
        <div class="forimg">
            <?=Html::img($model->getImageLink(), ['class' => '', 'style' => 'max-width: 250px;'])?>
            <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="delete-img-f"><?=Yii::t('app', 'Удалить картинку')?></a>
            <br><br>
        </div>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
