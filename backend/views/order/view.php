<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Order;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$idEdit = [];
$idEdit[] = '#status_edit_'.$model->id;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'old',
            [
                'attribute' => 'status',
                'format' => 'raw',
//                'value'=> $model->nameStatus(),
                'value'=>  '<a title="Редактировать" href="javascript:void(0);" data-source=\''.\yii\helpers\Json::encode(Order::statusList()).'\' data-value="'.$model->status.'" data-name="name" data-pk="'.$model->id.'" data-url="'.\yii\helpers\Url::toRoute('order/edit').'" id="status_edit_'.$model->id.'" data-type="select" data-title="Редактировать">'.$model->nameStatus().'</a>',

            ],
            'data_start',
            'data_finish',
            [
                'attribute' => 'user',
                'format' => 'raw',
                'value'=> isset($model->user0->username) ? $model->user0->username : null,
            ],
            'name',
            'soname',
            'email:email',
            'phone',
            'adress',
            'code',
            'city',
            'country',
            'region',
            [
                'attribute' => 'payment',
                'format' => 'raw',
                'value'=> isset($model->payment0->name) ? $model->payment0->name : null,
            ],
            [
                'attribute' => 'delivery',
                'format' => 'raw',
                'value'=> isset($model->delivery0->name) ? $model->delivery0->name : null,
            ],
            'agent:ntext',
            'fax',
            'icq',
            'skape',
            'coment_admin:ntext',
            [
                'label' => Yii::t('app', 'Товары'),
                'format' => 'raw',
                'value'=> join('<br>', $model->getListItems()),
            ],
        ],
    ]) ?>

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
