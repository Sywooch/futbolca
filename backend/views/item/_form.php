<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\widgets\TinyMce;
use backend\models\Element;
use backend\models\Item;
use backend\models\Fashion;

/* @var $this yii\web\View */
/* @var $model backend\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'element')->dropDownList(Element::getCatForListForBase(), ['prompt' => Yii::t('app', '-- Выберите основу -- ')])
            ->hint(Yii::t('app', 'Эта основа будет базовой')) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?php if(!$model->isNewRecord){ ?>
                <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'position')->textInput()->hint(Yii::t('app', 'По умолчанию = 0. В самом низу = 0')) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>
        <div class="col-sm-3 col-xs-12">
            <?= $form->field($model, 'active')->dropDownList(Item::listHome()) ?>
        </div>
        <div class="col-sm-3 col-xs-12">
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
    <?= $form->field($model, 'elementsFilter')->checkboxList(Fashion::getToList(), ['encode' => false]) ?>

    <?= $form->field($model, 'elements')->checkboxList(Element::getCatForListForItem(), ['encode' => false]) ?>

    <?= $form->field($model, 'categories')->listBox(\backend\models\Category::getCatForList(), [
        'prompt' => Yii::t('app', '-- Выберите категории -- '),
        'multiple' => true,
        'size' => 7,
    ]) ?>

    <?= $form->field($model, 'podcategories')->listBox(\backend\models\Podcategory::getCatForList($model->categories), [
        'prompt' => Yii::t('app', '-- Выберите подкатегории -- '),
        'multiple' => true,
        'size' => 7,
    ]) ?>

    <?= $form->field($model, 'markers')->checkboxList(\backend\models\Marker::getCatForList()) ?>

    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'text')->textarea(['rows' => 6, 'class' => 'myTinyMce']) ?>

    <?php for($i = 0; $i < 5; $i++){ ?>
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <?= $form->field($model, 'image[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

            </div>
            <div class="col-sm-6 col-xs-12">
                <?php if(isset($model->watermarks[$i])){ ?>
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <?= $form->field($model, 'imagePosition['.$model->watermarks[$i]->id.']')->textInput(['value' => (int)$model->watermarks[$i]->position]) ?>
                        </div>
                    </div>
                    <div id="forimg<?=$i?>">
                        <?=Html::img($model->getImageLink($i), ['class' => '', 'style' => 'max-width: 200px;'])?>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="deleteItemImg('<?=$i?>', '<?=$model->id?>', '<?=$model->watermarks[$i]->id?>');"><?=Yii::t('app', 'Удалить')?></a>
                        <br><br>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?=TinyMce::widget() ?>

</div>
<?php
$urlPodcat = Url::toRoute('item/podcat');
$urlFindElement = Url::toRoute('item/element');
$podcatPrompt = Yii::t('app', '-- Выберите подкатегории -- ');
$podcatList = '[\''.join('\', \'', $model->podcategories).'\']';
$elementsList = '[\''.join('\', \'', $model->elements).'\']';
$js = <<<JS

   function listr(list){
        var data = list;
        var ids = [];
        var elementsList = {$elementsList};
        $.each(data, function(i, item){
            if($(data[i]).prop('checked')){
                ids.push($(data[i]).val());
            }
        });
        $.ajax({
                type: "POST",
                cache : false,
                url: "{$urlFindElement}",
                data: ({data: ids}),
                dataType: 'json',
                success: function(msg){
                $('#item-elements').html('');
                if(msg.length < 1){
                    $('#item-elements').html('<p>Нет данных</p>');
                }
                    $.each(msg, function(i, item){
                        if(jQuery.inArray(i, elementsList) >= 0){
                            $('#item-elements').append(' <label><input type="checkbox" name="Item[elements][]" value="' + i + '" checked> ' + item + '</label> ');
                        }else{
                            $('#item-elements').append(' <label><input type="checkbox" name="Item[elements][]" value="' + i + '"> ' + item + '</label> ');
                        }
                    });
                }
            });
    }

$( document ).ready(function() {
    var list = $('#item-elementsfilter input:checked');
    listr(list);
});

$('#item-elementsfilter input').click(function(){
    var data = $('#item-elementsfilter input');
    listr(data);
});
    function deleteItemImg(id, model, watermark){
        $.get("/admin/item/deleteimg/", {model: model, watermark : watermark}, function(){
            $('#forimg' + id).hide();
        });
    };
    $('#item-categories').change(function(){
        var data = $(this).val();
        var podcat = {$podcatList};
        $.ajax({
            type: "POST",
            cache : false,
            url: "{$urlPodcat}",
            data: ({data: data}),
            dataType: 'json',
            success: function(msg){
            $('#item-podcategories').html('');
            $('#item-podcategories').append('<option value="">{$podcatPrompt}</option>');
                $.each(msg, function(i, item){
                    if(jQuery.inArray(i, podcat) >= 0){
                        $('#item-podcategories').append('<option value="' + i + '" selected="selected">' + item + '</option>');
                    }else{
                        $('#item-podcategories').append('<option value="' + i + '">' + item + '</option>');
                    }
                });
            }
        });
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-img-delete-item');
