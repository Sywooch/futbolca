<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Country;
use backend\models\Region;

/* @var $this yii\web\View */
/* @var $model backend\models\City */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="city-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'country')->dropDownList(Country::listDrop(), ['prompt' => Yii::t('app', '-- выберите страну -- ')]) ?>

    <?php if( $model->isNewRecord){ ?>
        <?= $form->field($model, 'region')->dropDownList([], ['prompt' => Yii::t('app', '-- выберите страну -- ')]) ?>
    <?php }else{ ?>
        <?= $form->field($model, 'region')->dropDownList(Region::listDrop($model->country), ['prompt' => Yii::t('app', '-- выберите область -- ')]) ?>
    <?php } ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$url = \yii\helpers\Url::toRoute('city/regions');
$currentId = isset($model->id) ? $model->id : 0;
$js = <<<JS
    $('#city-country').change(function(){
        var id = $(this).val();
         var currentId = '{$currentId}';
        $.ajax({
            type: "POST",
            cache : false,
            url: "{$url}",
            data: ({id: id}),
            dataType: 'json',
            success: function(msg){
            $('#city-region').html('');
            $('#city-region').append('<option value="">-- выберите область -- </option>');
                $.each(msg, function(i, item){
                    if(i == currentId){
                        $('#city-region').append('<option value="' + i + '" selected="selected">' + item + '</option>');
                    }else{
                        $('#city-region').append('<option value="' + i + '">' + item + '</option>');
                    }
                });
            }
        });
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-edit-statur');
