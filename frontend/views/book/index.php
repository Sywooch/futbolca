<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\Book;
use app\models\Author;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Книги');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="book-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Создать книгу'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'preview',
                'format' => 'raw',
                'value'=> function ($model) {
                    return Html::a(Html::img($model->imgUrl()), $model->imgUrl(false), ['title' => $model->name, 'rel' => 'lightgallery']);
                },
                'filter' => false,
            ],
            [
                'attribute' => 'author',
                'format' => 'raw',
                'value'=> function ($model) {
                    return $model->author0->name;
                },
                'filter' => Author::getAllForDropDownList(false),
            ],
            'date',
             'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {view} {delete}',
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        return Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['book/view', 'id' => $model->id]),
                            ['title' => Yii::t('app', 'Просмотр'), 'data-toggle' => 'modal', 'data-target' => '#previewModal']);
                    }
                ],
            ],
        ],
    ]); ?>

</div>
