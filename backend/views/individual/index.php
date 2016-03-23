<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Individual;
use yii\helpers\Url;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\IndividualSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Individuals');
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
?>
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="individual-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Individual'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-share"></i> '.Yii::t('app', 'Экспорт в Excel'), ['excel', Yii::$app->request->get()], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
    </p>
    <script>
        var DATE_INPUT = 'input[name=IndividualSearch\\[created\\]]';
    </script>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $idEdit[] = '#status_edit_'.$model->id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-name="status" data-source=\''.Json::encode(Individual::listStatus()).'\' data-value="'.$model->status.'" data-pk="'.$model->id.'" data-url="'.Url::toRoute('individual/status').'" id="status_edit_'.$model->id.'" data-type="select" data-title="Редактировать">'.Individual::getStatusName($model->status).'</a>';
                },
                'filter' => Individual::listStatus(),
            ],
            'name',
            'phone',
            'email:email',
//            'comment:ntext',
             'created',
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
