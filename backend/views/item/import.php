<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Fashion;


/* @var $this yii\web\View */
/* @var $model backend\models\Item */

$this->title = Yii::t('app', 'Импорт из Excel');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fashion-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?=Yii::t('app', 'Файл в формате .xlsx. Обновляются <strong>ТОЛЬКО наценка</strong>! Цены указывать целым числом! Первая строка не учитывается.<br>Столбцы: ID | Название | Позиция | Url | Код (артикул) | Наценка | Активный')?></p>
    <div class="fashion-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= Html::input('file', 'excel') ?>
        <br>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Импорт'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>