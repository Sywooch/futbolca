<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\News */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?=Yii::t('app', 'News')?>: "<?= Html::encode($this->title) ?>"</h4>
</div>
<div class="modal-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url',
            'description',
            'keywords',
            'small:ntext',
            'text:ntext',
            'created',
        ],
    ]) ?>
</div>
<div class="modal-footer">
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <button type="button" class="btn btn-warning" data-dismiss="modal"><?=Yii::t('app', 'Закрыть')?></button>
</div>
