<?php
/**
 * powered by php-shaman
 * HomeLogin.php 08.03.2016
 * NewFutbolca
 */
/* @var $model \frontend\models\News */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="box">
    <div class="box-title">
        <span class="heading"><?=Yii::t('app', 'Логин')?></span>
    </div>
    <div class="box-content">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form-homepage',
            'method' => 'post',
            'action' => Url::toRoute('site/login'),
        ]); ?>
            <?=Yii::t('app', 'E-mail')?>:<br /><input type="text" name="LoginForm[username]" value="" size="20">
            <?=Yii::t('app', 'Пароль')?>:<br /><input type="password" name="LoginForm[password]" value="" size="20">
            <br><input type="checkbox" name="LoginForm[rememberMe]" value="1" checked> <?=Yii::t('app', 'Запомнить меня')?>
            <br><input type="submit" value="<?=Yii::t('app', 'Войти')?>">
            <br><a href="<?=Url::toRoute('site/requestpasswordreset')?>" title="<?=Html::encode(Yii::t('app', 'Восстановить забытый пароль'))?>"><?=Yii::t('app', 'Забыли пароль?')?></a>
            <br><a href="<?=Url::toRoute('user/registry')?>" title="<?=Html::encode(Yii::t('app', 'Зарегистрироваться на сайте'))?>" style="color: #CC0000;"><strong><?=Yii::t('app', 'Регистрация')?></strong></a>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="box-bot"></div>
</div>
