<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PodcategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Podcategories');
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
?>
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="podcategory-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Podcategory'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'category',
                'value'=> function ($model) {
                    return $model->category0->name;
                },
                'filter' =>  \backend\models\Category::getCatForList(),

            ],
            [
                'attribute' => 'position',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $idEdit[] = '#status_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="status" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('podcategory/status').'" id="status_edit_'.$model->id.'" data-type="text" data-title="Редактировать">'.$model->position.'</a>';
                },
            ],
            'name',
            'url',
            // 'description',
            // 'keywords',
            // 'text:ntext',
            // 'text2:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        return Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::toRoute(['view', 'id' => $model->id]),
                            ['title' => Yii::t('app', 'Просмотр'), 'data-toggle' => 'modal', 'data-target' => '#previewModal']);
                    }
                ],
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
