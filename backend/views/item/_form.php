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
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?php if($model->getErrors()){ ?>
        <?php foreach($model->getErrors() AS $e){ ?>
            <p class="text-danger"><?=str_replace('Основа', 'Назначить основной', $e[0])?></p>
        <?php } ?>
    <?php } ?>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#item" aria-controls="home" role="tab" data-toggle="tab"><?=Yii::t('app', 'Описание')?></a></li>
        <li role="presentation"><a href="#categories" aria-controls="profile" role="tab" data-toggle="tab"><?=Yii::t('app', 'Категории')?></a></li>
        <li role="presentation"><a href="#metky" aria-controls="messages" role="tab" data-toggle="tab"><?=Yii::t('app', 'Метки')?></a></li>
        <li role="presentation"><a href="#osnova" aria-controls="settings" role="tab" data-toggle="tab"><?=Yii::t('app', 'Основы')?></a></li>
        <li role="presentation"><a href="#watermarks" aria-controls="settings" role="tab" data-toggle="tab"><?=Yii::t('app', 'Наложения')?></a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="item">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
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
                <div class="col-sm-6 col-xs-12">
                    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <?= $form->field($model, 'text')->textarea(['rows' => 6, 'class' => 'myTinyMce']) ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="categories">
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
        </div>
        <div role="tabpanel" class="tab-pane" id="metky">
            <?= $form->field($model, 'markers')->checkboxList(\backend\models\Marker::getCatForList()) ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="osnova">
            <div class="row">
                <div class="col-sm-2 col-xs-12">
                    <?= $form->field($model, 'elementsFilter')->checkboxList(Fashion::getToList(), ['encode' => false]) ?>
                </div>
                <div class="col-sm-10 col-xs-12">
                    <label>
                        <input name="changeAll" value="1" type="checkbox" id="changeAllId">
                        <label for="changeAllId"><?=Yii::t('app', 'Выбраь все основы')?></label>
                    </label>
                    <div class="form-group field-item-elements">
                        <label class="control-label" for="item-elements"><?=Yii::t('app', 'Основы')?></label>
                        <input type="hidden" name="Item[elements]" value=""><div id="item-elements">
                            <?=$this->render('listElements', [
                                'model' => $model,
                                'data' => [],
                            ])?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="watermarks">
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
        </div>
    </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if(!$model->isNewRecord){ ?>
            <a href="<?=str_replace('/admin/', '/', Url::toRoute(['item/view', 'url' => $model->url, 'preview' => 1]))?>" class="btn btn-warning" target="_blank"><?=Yii::t('app', 'Предпросмотр (сначала сохранить изменения)')?></a>
            <?php } ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<?=TinyMce::widget() ?>
<?php
$iremId = isset($model->id) ? $model->id : 0;
$urlPodcat = Url::toRoute('item/podcat');
$urlFindElement = Url::toRoute('item/element');
$podcatPrompt = Yii::t('app', '-- Выберите подкатегории -- ');
$podcatList = '[]';
if(is_array($model->podcategories)){
    $podcatList = '[\''.join('\', \'', $model->podcategories).'\']';
}
$elementsList = '[]';
if(is_array($model->elements)){
    $elementsList = '[\''.join('\', \'', $model->elements).'\']';
}
$checkedelement = $model->element;
$js = <<<JS

$('#changeAllId').click(function(){
    var props = $(this).prop('checked');
    $.each($('#item-elements input[type=checkbox]'), function(index, value){
        $(this).prop('checked', props);
    });
});


   function listr(list){
        var data = list;
        var ids = [];
        var elementsList = {$elementsList};
        var heckedelement = '{$checkedelement}';
        var itemId = {$iremId};
        $.each(data, function(i, item){
            if($(data[i]).prop('checked')){
                ids.push($(data[i]).val());
            }
        });
        $.ajax({
                type: "POST",
                cache : false,
                url: "{$urlFindElement}",
                data: ({data: ids, id : itemId}),
                dataType: 'html',
                beforeSend: function(){
                    $('#item-elements').html('Идет обновление, ждите');
                },
                error: function(){
                    alert('Ошибка запроса к серверу, обновите страницу и попробуйте снова')
                },
                success: function(msg){
                    $('#item-elements').html(msg);
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
            beforeSend: function(){
                $('#item-podcategories').html('<option value="">Идет обновление, ждите</option>');
            },
            error: function(){
                alert('Ошибка запроса к серверу, обновите страницу и попробуйте снова')
            },
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
