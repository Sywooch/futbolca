<?php
/**
 * powered by php-shaman
 * UserBlock.php 11.03.2016
 * NewFutbolca
 */

namespace frontend\widgets;


class UserBlock extends \yii\bootstrap\Widget
{
    public function init(){
        parent::init();
    }

    public function run(){

        return $this->render('UserBlock', [

        ]);
    }
}