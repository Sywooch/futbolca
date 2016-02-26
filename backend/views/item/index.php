<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Element;
use backend\models\Item;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="item-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'format' => 'raw',
                'value'=> function ($model) {
                    return Html::img($model->getImageLink(), ['class' => 'img-responsive', 'style' => 'max-width: 60px;']);
                },
                'filter' =>  false,
            ],
            'id',
            'name',
            'position',
            'url',
            [
                'attribute' => 'element',
                'format' => 'raw',
                'value'=> function ($model) {
                    return $model->element0->name;
                },
                'filter' =>  Element::getCatForList(),
            ],
             'code',
             'price',
            [
                'attribute' => 'active',
                'format' => 'raw',
                'value'=> function ($model) {
                    return Item::listHomeName($model->active);
                },
                'filter' =>  Item::listHome(),
            ],
            [
                'attribute' => 'home',
                'format' => 'raw',
                'value'=> function ($model) {
                    return Item::listHomeName($model->home);
                },
                'filter' =>  Item::listHome(),
            ],

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
