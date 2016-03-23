<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
?>
<div class="settings-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Settings'), ['create'], ['class' => 'btn btn-success']) ?>
        <a href="javascript:void(0);" class="btn btn-danger pull-right" id="cacheDelete"><?=Yii::t('app', 'Очистить кешь')?></a>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'value',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $idEdit[] = '#value_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="value" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('settings/edit').'" id="value_edit_'.$model->id.'" data-type="text" data-title="Редактировать">'.Html::encode($model->value).'</a>';
                },
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $idEdit[] = '#title_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="title" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('settings/edit').'" id="title_edit_'.$model->id.'" data-type="text" data-title="Редактировать">'.$model->title.'</a>';
                },
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<?php
$url = \yii\helpers\Url::toRoute(['settings/cache']);
$url2 = str_replace('/admin/', '/',  \yii\helpers\Url::toRoute(['search/cache']));
$url2 = rtrim($url2, '/').'.html';
$idEdit = join(', ', $idEdit);
$js = <<<JS
$(document).ready(function() {
    var ListDesc = '{$idEdit}';
    $(ListDesc).editable();
});
$('#cacheDelete').click(function(){
        $.ajax({
            type: "GET",
            cache : false,
            url: "{$url2}",
            data: ({e: 1}),
            dataType: 'json',
            success: function(msg){
                alert('Удалено!');
            }
        });
        $.ajax({
            type: "GET",
            cache : false,
            url: "{$url}",
            data: ({e: 1}),
            dataType: 'json',
            success: function(msg){
                //alert('Удалено!');
            }
        });
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-edit-statur');
