<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Country;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RegionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Regions');
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
?>
<div class="region-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Region'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'name',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'name_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="name" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('region/edit').'" id="'.$id.'" data-type="text" data-title="Редактировать">'.$model->name.'</a>';
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
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
