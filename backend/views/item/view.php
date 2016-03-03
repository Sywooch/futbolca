<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\Element;
use backend\models\Item;
use yii\helpers\Json;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Item */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h3 class="modal-title" id="myModalLabel"><?=Yii::t('app', 'Item')?>: "<?= Html::encode($this->title) ?>"</h3>
<p class="pull-right">
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'onclick' => 'return confirm(\''.Yii::t('app', 'Уверенны, что нужно удалить?').'\');',
    ]) ?>
</p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'position',
            'url',
            [
                'attribute' => 'element',
                'value'=> $model->element0->name.' ('.$model->element0->fashion0->name.')',
            ],
            'code',
            'description',
            'keywords',
            'price',
            [
                'attribute' => 'active',
                'value'=> Item::listHomeName($model->active),
            ],
            [
                'attribute' => 'home',
                'value'=> Item::listHomeName($model->home),
            ],
            'toppx',
            'leftpx',
            'text:ntext',
            [
                'label' => Yii::t('app', 'Дополнительные основы'),
                'format' => 'raw',
                'value'=> join('<br>', $model->listElements()),
            ],
            [
                'label' => Yii::t('app', 'Категории'),
                'format' => 'raw',
                'value'=> join('<br>', $model->listCat()),
            ],
            [
                'label' => Yii::t('app', 'Метки'),
                'format' => 'raw',
                'value'=> join('<br>', $model->listM()),
            ],
        ],
    ]) ?>

