<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Country;
use backend\models\Region;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cities');
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
?>
<div class="city-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create City'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'country',
                'format' => 'raw',
                'value'=> function ($model) {
                    return isset($model->country0->name) ? $model->country0->name : null;
                },
                'filter' =>  Country::listDrop(),
            ],
            [
                'attribute' => 'region',
                'format' => 'raw',
                'value'=> function ($model) {
                    return isset($model->region0->name) ? $model->region0->name : null;
                },
                'filter' =>  Region::listDrop(isset(Yii::$app->request->get('CitySearch')['country']) ? (int)Yii::$app->request->get('CitySearch')['country'] : 0),
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'name_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="name" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('city/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.$model->name.'</a>';
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
            ],
        ],
    ]); ?>

</div>
<?php
$url = \yii\helpers\Url::toRoute('city/regions');
$idEdit = join(', ', $idEdit);
$js = <<<JS
$(document).ready(function() {
    var ListDesc = '{$idEdit}';
    $(ListDesc).editable();
});
$('input[name=CitySearch\\[id\\]]').change(function(){
        var id = $(this).val();
        var names = 'input[name=CitySearch\\[region\\]]';
        $.ajax({
            type: "POST",
            cache : false,
            url: "{$url}",
            data: ({id: id}),
            dataType: 'json',
            success: function(msg){
                $(names).html('');
                $.each(msg, function(i, item){
                    $(names).append('<option value="' + i + '">' + item + '</option>');
                });
            }
        });
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-edit-statur');
