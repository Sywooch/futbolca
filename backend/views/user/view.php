<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            'username',
            [
                'attribute' => 'role',
                'value'=> User::getRoleName($model->role),
            ],
            'email:email',
            [
                'attribute' => 'status',
                'value'=> User::getStatusName($model->status),
            ],
            [
                'attribute' => 'created_at',
                'value'=> date("d/m/Y", $model->created_at),
            ],
            [
                'label' => Yii::t('app', 'Имя'),
                'value'=> $model->description0->name,
            ],
            [
                'label' => Yii::t('app', 'Фамилия'),
                'value'=> $model->description0->soname,
            ],
            [
                'label' => Yii::t('app', 'Телефон'),
                'value'=> $model->description0->phone,
            ],
            [
                'label' => Yii::t('app', 'Факс'),
                'value'=> $model->description0->fax,
            ],            [
                'label' => Yii::t('app', 'Адресс'),
                'value'=> $model->description0->adress,
            ],            [
                'label' => Yii::t('app', 'Город'),
                'value'=> $model->description0->city,
            ],            [
                'label' => Yii::t('app', 'Регион'),
                'value'=> $model->description0->region,
            ],            [
                'label' => Yii::t('app', 'Область'),
                'value'=> $model->description0->country,
            ],
            [
                'label' => Yii::t('app', 'Индекс'),
                'value'=> $model->description0->code,
            ],
            [
                'label' => Yii::t('app', 'Скайп'),
                'value'=> $model->description0->skape,
            ],
            [
                'label' => Yii::t('app', 'ICQ'),
                'value'=> $model->description0->icq,
            ],
            [
                'label' => Yii::t('app', 'IP'),
                'value'=> $model->description0->ip,
            ],
            [
                'label' => Yii::t('app', 'Разное'),
                'value'=> $model->description0->agent,
            ],
        ],
    ]) ?>

</div>
