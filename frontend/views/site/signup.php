<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Регистрация');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $this->title
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title
]);
$this->registerJsFile('/js/jquery.maskedinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$js = <<<JS
    jQuery(function($){
        $("#signupform-phone").mask("+38(099)999-99-99");
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-phone-ms');
?>
<div class="products">
    <h1 class="page-title"><?=Yii::t('app', 'Регистрация')?></h1>
    <p style="text-align: center;"><?=Yii::t('app', 'Заполните следующие поля, чтобы зарегистрироваться')?>:</p>
    <p style="text-align: center; color:#FF0000;"></p>
    <p></p>
    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <table width="100%" border="0" cellspacing="4" cellpadding="4">
            <tr>
                <td>Логин <b class="toRec">*</b></td>
                <td><?= $form->field($model, 'username')->textInput(['autofocus' => true, 'size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>E-mail <b class="toRec">*</b></td>
                <td><?= $form->field($model, 'email')->textInput(['size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>Имя</td>
                <td><?= $form->field($model, 'name')->textInput(['size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>Фамилия</td>
                <td><?= $form->field($model, 'soname')->textInput(['size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>Телефон</td>
                <td><?= $form->field($model, 'phone')->textInput(['size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>Почтовый индекс</td>
                <td><?= $form->field($model, 'code')->textInput(['size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>Область</td>
                <td><?= $form->field($model, 'country')->textInput(['size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>Город</td>
                <td><?= $form->field($model, 'city')->textInput(['size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>Адресс</td>
                <td><?= $form->field($model, 'adress')->textInput(['size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>Пароль <b class="toRec">*</b> <sub>(от 6 до 12 символов)</sub></td>
                <td><?= $form->field($model, 'password')->passwordInput(['size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>Повторить пароль <b class="toRec">*</b></td>
                <td><?= $form->field($model, 'passto')->passwordInput(['size' => 35])->label('') ?></td>
            </tr>
            <tr>
                <td>Я не робот <b class="toRec">*</b></td>
                <td>
                    <?= $form->field($model, 'verifyCode')->widget(
                        \common\recaptcha\ReCaptcha::className(),
                        ['siteKey' => \common\recaptcha\ReCaptcha::SITE_KEY]
                    )->label('') ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><?= Html::submitButton(Yii::t('app', 'Регистрация'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?></td>
            </tr>
        </table>
    <?php ActiveForm::end(); ?>
</div>

