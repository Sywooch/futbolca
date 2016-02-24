<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Книги'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Книга: "<?= Html::encode($this->title) ?>"</h4>
</div>
<div class="modal-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'date',
            [
                'attribute' => 'author',
                'value'=> $model->author0->name,
            ],
            'created_at',
//            'updated_at',
            [
                'attribute' => 'preview',
                'format' => 'raw',
                'value'=> Html::img($model->imgUrl()),
            ],
        ],
    ]) ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-warning" data-dismiss="modal"><?=Yii::t('app', 'Закрыть')?></button>
</div>
