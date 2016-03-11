<?php
/**
 * powered by php-shaman
 * UserBlock.php 11.03.2016
 * NewFutbolca
 */

/* @var $model \frontend\models\News */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="box">
    <div class="box-title">
        <span class="heading"><?=Yii::t('app', 'Меню пользователя')?></span>
    </div>
    <div class="box-content">
        <strong><?=Yii::$app->user->identity->email?></strong>
        <br><br>
        <ul class="cat-list">
            <li><a href="<?=Url::toRoute(['user/settings'])?>" title="<?=Html::encode(Yii::t('app', 'Настройки e-mail и пароля'))?>"><?=Yii::t('app', 'Настройки')?></a></li>
            <li><a href="<?=Url::toRoute(['user/information'])?>" title="<?=Html::encode(Yii::t('app', 'Данные для заказа'))?>"><?=Yii::t('app', 'Данные')?></a></li>
            <li><a href="<?=Url::toRoute(['user/car'])?>" title="<?=Html::encode(Yii::t('app', 'Собраны все товары'))?>"><?=Yii::t('app', 'Корзина')?></a></li>
            <li><a href="<?=Url::toRoute(['user/orders'])?>" title="<?=Html::encode(Yii::t('app', 'Список Ваших покупок'))?>"><?=Yii::t('app', 'Заказы')?></a></li>
            <li>
                <?=Html::beginForm(['/site/logout'], 'post', ['id' => 'logout-form'])?>
                <a href="javascript:void(0);" class="logoutLink" title="<?=Html::encode(Yii::t('app', 'Выход'))?>"><?=Yii::t('app', 'Выход')?></a>
                <?=Html::endForm()?>
            </li>
        </ul>
    </div>
    <div class="box-bot"></div>
</div>

