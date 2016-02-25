<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Proportion;
use backend\models\Fashion;
use backend\models\Element;

/* @var $this yii\web\View */
/* @var $model backend\models\Element */
/* @var $fashion backend\models\Fashion */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
    $('#delete-img-f').click(function(){
        $.get("/admin/element/deleteimg/?id={$model->id}", {}, function(){
            $('.forimg').hide();
        });
    });
    $('input[name=newf]').click(function(){
        $('#addNewF').toggle();
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-img-delete');
?>

<div class="model-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <?= $form->field($model, 'fashion')->dropDownList(Fashion::getToList(), ['prompt' => '-- Выберите фасон --']) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <div class="form-group field-element-stock">
            <label class="control-label" for="element-fashion">&nbsp;</label>
                <div id="element-size">
                    <label>
                        <?=Yii::t('app', 'или создать новый фасон')?> <input type="checkbox" name="newf" value="1" <?=(isset($_POST['Fashion']['name']) && $_POST['Fashion']['name']) ? 'checked="checked"' : ''?>>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div id="addNewF" style="display: <?=(isset($_POST['Fashion']['name']) && $_POST['Fashion']['name']) ? 'block' : 'none'?>;">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <?= $form->field($fashion, 'name')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Для нового фасона')) ?>
            </div>
            <div class="col-sm-6 col-xs-12">
                <?= $form->field($fashion, 'price')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Для нового фасона')) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'stock')->dropDownList(Element::listHome()) ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $form->field($model, 'home')->dropDownList(Element::listHome()) ?>
        </div>
    </div>
    <?= $form->field($model, 'size')->checkboxList(Proportion::getToList()) ?>
    <?php foreach(Proportion::getToList() AS $idSize => $sizeName){ ?>


    <?php } ?>
    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'toppx')->textInput() ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'leftpx')->textInput() ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'increase')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($model, 'resizeW')->textInput()->hint(Yii::t('app', 'можно указать один параметр - второй рассчитывается пропорционально')) ?>
        </div>
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($model, 'resizeH')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?php if($model->photo){ ?>
        <div class="forimg">
            <?=Html::img($model->getImageLink(), ['class' => '', 'style' => 'max-width: 200px;'])?>
            <a href="javascript:void(0);" class="btn btn-danger btn-sm" id="delete-img-f"><?=Yii::t('app', 'Удалить картинку')?></a>
            <br><br>
        </div>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
