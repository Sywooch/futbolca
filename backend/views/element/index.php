<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\models\Element;
use backend\models\Fashion;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ElementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Models');
$this->params['breadcrumbs'][] = $this->title;
$idList = [];
?>
<div class="model-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Model'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-share"></i> '.Yii::t('app', 'Экспорт в Excel'), ['excel', Yii::$app->request->get()], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-floppy-save"></i> '.Yii::t('app', 'Импорт из Excel'), ['import'], ['class' => 'btn btn-info']) ?>

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value'=> function ($model) {
                    return Html::img($model->getImageLink(), ['class' => 'img-responsive', 'style' => 'max-width: 60px;']);
                },
                'filter' =>  false,
            ],
            'id',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value'=> function ($model) use(&$idList) {
                    $idTag = 'name_edit_'.$model->id;
                    $idList[] = '#'.$idTag;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="name" data-pk="'.$model->id.'" data-url="'.Url::toRoute('element/edit').'" id="'.$idTag.'" data-type="text" data-title="Редактировать">'.$model->name.'</a>';
                },
            ],
            [
                'attribute' => 'stock',
                'format' => 'raw',
                'value'=> function ($model) use(&$idList) {
                    $idTag = 'stock_edit_'.$model->id;
                    $idList[] = '#'.$idTag;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="stock" data-value="'.$model->stock.'" data-source=\''.Json::encode(Element::listHome()).'\' data-pk="'.$model->id.'" data-url="'.Url::toRoute('element/edit').'" id="'.$idTag.'" data-type="select" data-title="Редактировать">'.Element::listHomeName($model->stock).'</a>';
                },
                'filter' =>  Element::listHome(),
            ],
            [
                'attribute' => 'home',
                'format' => 'raw',
                'value'=> function ($model) use(&$idList) {
                    $idTag = 'stock_edit_'.$model->id;
                    $idList[] = '#'.$idTag;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="home" data-value="'.$model->home.'" data-source=\''.Json::encode(Element::listHome()).'\' data-pk="'.$model->id.'" data-url="'.Url::toRoute('element/edit').'" id="'.$idTag.'" data-type="select" data-title="Редактировать">'.Element::listHomeName($model->home).'</a>';
                },
                'filter' =>  Element::listHome(),
            ],
            [
                'attribute' => 'fashion',
                'format' => 'raw',
                'value'=> function ($model) {
                    return $model->fashion0->name;
                },
                'filter' =>  Fashion::getToList(),
            ],
            [
                'attribute' => 'toppx',
                'format' => 'raw',
                'value'=> function ($model) use(&$idList) {
                    $idTag = 'toppx_edit_'.$model->id;
                    $idList[] = '#'.$idTag;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="toppx" data-pk="'.$model->id.'" data-url="'.Url::toRoute('element/edit').'" id="'.$idTag.'" data-type="text" data-title="Редактировать">'.$model->toppx.'</a>';
                },
            ],
            [
                'attribute' => 'leftpx',
                'format' => 'raw',
                'value'=> function ($model) use(&$idList) {
                    $idTag = 'leftpx_edit_'.$model->id;
                    $idList[] = '#'.$idTag;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="leftpx" data-pk="'.$model->id.'" data-url="'.Url::toRoute('element/edit').'" id="'.$idTag.'" data-type="text" data-title="Редактировать">'.$model->leftpx.'</a>';
                },
            ],
            [
                'attribute' => 'price',
                'format' => 'raw',
                'value'=> function ($model) use(&$idList) {
                    $idTag = 'price_edit_'.$model->id;
                    $idList[] = '#'.$idTag;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="price" data-pk="'.$model->id.'" data-url="'.Url::toRoute('element/edit').'" id="'.$idTag.'" data-type="text" data-title="Редактировать">'.$model->price.'</a>';
                },
            ],
            [
                'attribute' => 'increase',
                'format' => 'raw',
                'value'=> function ($model) use(&$idList) {
                    $idTag = 'increase_edit_'.$model->id;
                    $idList[] = '#'.$idTag;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="increase" data-pk="'.$model->id.'" data-url="'.Url::toRoute('element/edit').'" id="'.$idTag.'" data-type="text" data-title="Редактировать">'.$model->increase.'</a>';
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
            ],
        ],
    ]); ?>

</div>
<?php

$idList = join(', ', $idList);
$js = <<<JS
$(document).ready(function() {
    var ListDesc = '{$idList}';
    $(ListDesc).editable();
});
JS;
$this->registerJs($js, $this::POS_END, 'my-edit-statur');
