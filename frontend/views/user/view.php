<?php
/**
 * powered by php-shaman
 * view.php 11.03.2016
 * NewFutbolca
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\Order */

use yii\helpers\Html;
use frontend\models\Order;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Заказ №{order}', ['order' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заказы'), 'url' => ['user/orders']];
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

<h1 class="page-title"><?=Yii::t('app', 'Заказ №{order}', ['order' => $model->id])?></h1>
<p style="color: green; font-size: 16px; text-align: center;"><?=Yii::$app->session->getFlash('success')?></p>
<p></p>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'status',
            'format' => 'raw',
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
        'fax',
        'icq',
        'skape',
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
        [
            'label' => Yii::t('app', 'Товары'),
            'format' => 'raw',
            'value'=> join('<br>', $model->getListItems()),
        ],
    ],
]) ?>

