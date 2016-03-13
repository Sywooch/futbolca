<?php
/**
 * powered by php-shaman
 * HomeCart.php 13.03.2016
 * NewFutbolca
 */
use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="cart">
    <span class="cart-title"><?=Yii::t('app', 'Ваша корзина')?></span>
    <p><strong id="cartCount"><?=(int)$data['count']?></strong> <span id="lengv"><?=Yii::t('app', 'товаров')?></span></p>
    <p><?=Yii::t('app', 'на сумму')?> <strong id="cartSum"><?=Yii::$app->formatter->asInteger((int)$data['sum'])?></strong> <?=Yii::t('app', 'грн.')?></p>
    <a href="<?=Url::toRoute(['cart/index'])?>" title="<?=Html::encode(Yii::t('app', 'Оформить заказ'))?>"><?=Yii::t('app', 'Оформить заказ')?></a>
</div>
