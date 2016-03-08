<?php
/**
 * powered by php-shaman
 * HomeLogin.php 08.03.2016
 * NewFutbolca
 */

namespace frontend\widgets;


class HomeLogin extends \yii\bootstrap\Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('HomeLogin', [

        ]);
    }
}