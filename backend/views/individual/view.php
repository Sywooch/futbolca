<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Individual;

/* @var $this yii\web\View */
/* @var $model backend\models\Individual */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Individuals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?=Yii::t('app', 'Category')?>: "<?= Html::encode($this->title) ?>"</h4>
</div>
<div class="modal-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created',
            [
                'attribute' => 'status',
                'value'=> Individual::getStatusName($model->status),
            ],
            'name',
            'phone',
            'email:email',
            'comment:ntext',
            [
                'attribute' => 'img1',
                'format' => 'raw',
                'value'=> $model->img1 ? Html::img($model->getImageLink(1), ['class' => 'img-responsive', 'style' => 'max-width: 300px;']) : '',
            ],
            [
                'attribute' => 'img2',
                'format' => 'raw',
                'value'=> $model->img2 ? Html::img($model->getImageLink(2), ['class' => 'img-responsive', 'style' => 'max-width: 300px;']) : '',
            ],
            [
                'attribute' => 'img3',
                'format' => 'raw',
                'value'=> $model->img3 ? Html::img($model->getImageLink(3), ['class' => 'img-responsive', 'style' => 'max-width: 300px;']) : '',
            ],
            [
                'attribute' => 'img4',
                'format' => 'raw',
                'value'=> $model->img4 ? Html::img($model->getImageLink(4), ['class' => 'img-responsive', 'style' => 'max-width: 300px;']) : '',
            ],
        ],
    ]) ?>
</div>
<div class="modal-footer">
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <button type="button" class="btn btn-warning" data-dismiss="modal"><?=Yii::t('app', 'Закрыть')?></button>
</div>

