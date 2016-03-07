<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\models\Element;
use backend\models\Item;
use yii\helpers\Json;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
?>
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="item-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Item'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-share"></i> '.Yii::t('app', 'Экспорт в Excel'), ['excel', Yii::$app->request->get()], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-floppy-save"></i> '.Yii::t('app', 'Импорт из Excel'), ['import'], ['class' => 'btn btn-info']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'format' => 'raw',
                'value'=> function ($model) {
                    return Html::img($model->getImageLink(), ['class' => 'img-responsive', 'style' => 'max-width: 60px;']);
                },
                'filter' =>  false,
            ],
//            'id',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'name_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="name" data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.$model->name.'</a>';
                },
            ],
            [
                'attribute' => 'position',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'position_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="position" data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.$model->position.'</a>';
                },
            ],
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'url_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="url" data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.$model->url.'</a>';
                },
            ],
            [
                'attribute' => 'element',
                'format' => 'raw',
                'value'=> function ($model) {
                    return $model->element0->name.'<br>('.$model->element0->fashion0->name.')';
                },
                'filter' =>  Element::getCatForList(),
            ],
            [
                'attribute' => 'categories',
                'format' => 'raw',
                'value'=> function ($model) {
                    return join('<br>', $model->listCat());
                },
                'filter' => Category::getCatForList(),
            ],
//            [
//                'attribute' => 'code',
//                'format' => 'raw',
//                'value'=> function ($model) use (& $idEdit) {
//                    $id = 'code_edit_'.$model->id;
//                    $idEdit[] = '#'.$id;
//                    return '<a title="Редактировать" href="javascript:void(0);" data-name="code" data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.$model->code.'</a>';
//                },
//            ],
            [
                'attribute' => 'price',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'price_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="price" data-pk="'.$model->id.'" data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.$model->price.'</a>';
                },
            ],
            [
                'attribute' => 'active',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'active_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="active" data-pk="'.$model->id.'" data-value="'.$model->active.'" data-source=\''.Json::encode(Item::listHome()).'\' data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="select" data-title="Редактировать">'.Item::listHomeName($model->active).'</a>';
                },
                'filter' =>  Item::listHome(),
            ],
            [
                'attribute' => 'home',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'home_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="home" data-pk="'.$model->id.'" data-value="'.$model->home.'" data-source=\''.Json::encode(Item::listHome()).'\' data-url="'.Url::toRoute('item/edit').'" id="'.$id.'" data-type="select" data-title="Редактировать">'.Item::listHomeName($model->home).'</a>';
                },
                'filter' =>  Item::listHome(),
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
//                'buttons'=>[
//                    'view'=>function ($url, $model) {
//                        return Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::toRoute(['view', 'id' => $model->id]),
//                            ['title' => Yii::t('app', 'Просмотр'), 'data-toggle' => 'modal', 'data-target' => '#previewModal']);
//                    }
//                ],
            ],
        ],
    ]); ?>

</div>
<?php

$idEdit = join(', ', $idEdit);
$js = <<<JS
$(document).ready(function() {
    var ListDesc = '{$idEdit}';
    $(ListDesc).editable();
});
JS;
$this->registerJs($js, $this::POS_END, 'my-edit-statur');
