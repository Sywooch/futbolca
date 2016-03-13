<?php
/**
 * powered by php-shaman
 * HomeCart.php 13.03.2016
 * NewFutbolca
 */

namespace frontend\widgets;


use frontend\models\Cart;
use Yii;

class HomeCart extends \yii\bootstrap\Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        $cart = Cart::getCartId();
        $data = Cart::cartCountItem($cart);
        return $this->render('HomeCart', [
            'cart' => $cart,
            'data' => $data,
        ]);
    }
}