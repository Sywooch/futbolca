<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PodcategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Podcategories');
$this->params['breadcrumbs'][] = $this->title;
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
            'position',
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
