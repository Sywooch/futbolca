<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
?>

<div class="order-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-share"></i> '.Yii::t('app', 'Экспорт в Excel'), ['excel', Yii::$app->request->get()], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>

    </p>
    <script>
        var DATE_INPUT = 'input[name=OrderSearch\\[data_start\\]]';
    </script>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'old',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value'=> function ($model) use (& $idEdit) {
                    $id = 'status_edit_'.$model->id;
                    $idEdit[] = '#'.$id;
                    return '<a title="Редактировать" href="javascript:void(0);" data-source=\''.\yii\helpers\Json::encode(Order::statusList()).'\' data-value="'.$model->status.'" data-name="name" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('order/edit').'" id="'.$id.'" data-type="select" data-title="Редактировать">'.$model->nameStatus().'</a>';
                },
                'filter' =>  Order::statusList(),
            ],
            [
                'attribute' => 'data_start',
                'format' => 'raw',
                'value'=> function ($model) {
                    return date("d/m/Y", strtotime($model->data_start)).'<br>'.date(" H:i:s", strtotime($model->data_start));
                },
            ],
//            [
//                'attribute' => 'data_finish',
//                'format' => 'raw',
//                'value'=> function ($model) {
//                    return date("d/m/Y H:i:s", strtotime($model->data_finish));
//                },
//            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value'=> function ($model) {
                    return $model->name.'<br>'.$model->soname;
                },
            ],
             'email:email',
             'phone',
            [
                'label' => Yii::t('app', 'Товары'),
                'format' => 'raw',
                'value'=> function ($model) {
                    return join('<br>', $model->getListItemsMini());
                },
                'filter' =>  false,
            ],


            ['class' => 'yii\grid\ActionColumn'],
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
