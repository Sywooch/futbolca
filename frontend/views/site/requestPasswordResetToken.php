<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Запрос на восстановление пароля');
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

<h1 class="page-title"><?=Yii::t('app', 'Запрос на восстановление пароля')?></h1>
<p><?=Yii::t('app', 'Пожалуйста, заполните вашу электронную почту. Ссылка для сброса пароля будет отправлена туда.')?></p>
<p style="color: green;"><?=Yii::$app->session->getFlash('success')?></p>
<p style="color: red;"><?=Yii::$app->session->getFlash('error')?></p>
<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'size' => 35]) ?>

            <?= $form->field($model, 'verifyCode')->widget(
                \common\recaptcha\ReCaptcha::className(),
                ['siteKey' => \common\recaptcha\ReCaptcha::SITE_KEY]
            )->label('') ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

