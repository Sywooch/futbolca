<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Fashion;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FashionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Fashions');
$this->params['breadcrumbs'][] = $this->title;
$idname = [];
$idprice = [];
$idactive = [];
?>
<div class="fashion-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Fashion'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-share"></i> '.Yii::t('app', 'Экспорт в Excel'), ['excel', Yii::$app->request->get()], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-floppy-save"></i> '.Yii::t('app', 'Импорт из Excel'), ['import'], ['class' => 'btn btn-info']) ?>

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value'=> function ($model) use (& $idname) {
                    $idname[] = '#name_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="name" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('fashion/editf').'" id="name_edit_'.$model->id.'" data-type="text" data-title="Редактировать">'.$model->name.'</a>';
                },
            ],
            [
                'attribute' => 'price',
                'format' => 'raw',
                'value'=> function ($model) use (& $idprice) {
                    $idprice[] = '#price_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="price" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('fashion/editf').'" id="price_edit_'.$model->id.'" data-type="text" data-title="Редактировать">'.$model->price.'</a>';
                },
            ],
            [
                'attribute' => 'active',
                'format' => 'raw',
                'value'=> function ($model) use (& $idactive) {
                    $idactive[] = '#active_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="active" data-source=\''.\yii\helpers\Json::encode(Fashion::listActive()).'\' data-value="'.$model->active.'" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('fashion/editf').'" id="active_edit_'.$model->id.'" data-type="select" data-title="Редактировать">'.Fashion::getActiveName($model->active).'</a>';
                },
                'filter' => Fashion::listActive(),
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',
            ],
        ],
    ]); ?>

</div>
<?php

$idname = join(', ', $idname);
$idprice = join(', ', $idprice);
$idactive = join(', ', $idactive);
$js = <<<JS
$(document).ready(function() {
        var ListDesc = '{$idname}';
        $(ListDesc).editable();
        var ListDesc2 = '{$idprice}';
        $(ListDesc2).editable();
        var ListDesc3 = '{$idactive}';
        $(ListDesc3).editable();
});
JS;
$this->registerJs($js, $this::POS_END, 'my-edit-statur');