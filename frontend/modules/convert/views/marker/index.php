<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Метки');
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1 class="page-title"><?=Yii::t('app', 'Метки')?></h1>
<?php $form = ActiveForm::begin(['id' => 'set-form']); ?>
<?= Html::input('hidden', 'ok', '1') ?>
<?= Html::submitButton(Yii::t('app', 'Начать конвертацию'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
<?php ActiveForm::end(); ?>