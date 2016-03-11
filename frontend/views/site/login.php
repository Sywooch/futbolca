<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Вход');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products">
    <h1 class="page-title"><?=Yii::t('app', 'Вход')?></h1>
    <p style="color: green;"><?=Yii::$app->session->getFlash('success')?></p>
    <p><?=Yii::t('app', 'Заполните следующие поля для входа')?>:</p>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <table width="100%" border="0" cellspacing="4" cellpadding="4">
        <tr>
            <td>E-mail <b class="toRec">*</b></td>
            <td><?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('') ?></td>
        </tr>
        <tr>
            <td>Пароль <b class="toRec">*</b></td>
            <td><?= $form->field($model, 'password')->passwordInput()->label('') ?></td>
        </tr>
        <tr>
            <td> </td>
            <td><?= $form->field($model, 'rememberMe')->checkbox() ?></td>
        </tr>
        <tr>
            <td> </td>
            <td>
                <?= Html::submitButton(Yii::t('app', 'Войти'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </td>
        </tr>
    </table>
    <?php ActiveForm::end(); ?>
</div>
