<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProportionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Proportions');
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
$idEdit2 = [];
?>
<div class="proportion-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Proportion'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'value'=> function ($model) use (& $idEdit) {
                    $idEdit[] = '#name_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="name" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('proportion/edit').'" id="name_edit_'.$model->id.'" data-type="text" data-title="Редактировать">'.$model->name.'</a>';
                },
            ],
            [
                'attribute' => 'text',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit2) {
                    $idEdit2[] = '#text_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="text" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('proportion/edit').'" id="text_edit_'.$model->id.'" data-type="textarea" data-title="Редактировать">'.Html::encode($model->text).'</a>';
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',
            ],
        ],
    ]); ?>

</div>

<?php

$idEdit = join(', ', $idEdit);
$idEdit2 = join(', ', $idEdit2);
$js = <<<JS
$(document).ready(function() {
    var ListDesc = '{$idEdit}';
    $(ListDesc).editable();
    var ListDesc2 = '{$idEdit2}';
    $(ListDesc2).editable();
});
JS;
$this->registerJs($js, $this::POS_END, 'my-edit-statur');