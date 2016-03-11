<?php
/**
 * powered by php-shaman
 * orders.php 11.03.2016
 * NewFutbolca
 */

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use frontend\models\Order;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Заказы');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $this->title
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title
]);
?>
<h1 class="page-title"><?=Yii::t('app', 'Заказы')?></h1>
<p></p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'status',
            'format' => 'raw',
            'value'=> function ($model) {
                return $model->nameStatus();
            },
            'filter' =>  Order::statusList(),
        ],
        [
            'attribute' => 'data_start',
            'format' => 'raw',
            'value'=> function ($model) {
                if(!$model->data_start){
                    return null;
                }
                return date("d/m/Y", strtotime($model->data_start));
            },
            'filter' =>  false,
        ],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value'=> function ($model) {
                return $model->name.'<br>'.$model->soname;
            },
            'filter' =>  false,
        ],

        [
            'label' => Yii::t('app', ' '),
            'format' => 'raw',
            'value'=> function ($model) {
                return Html::a(Yii::t('app', 'Подробно'), ['user/view', 'id' => $model->id]);
            },
            'filter' =>  false,
        ],
    ],
]); ?>

