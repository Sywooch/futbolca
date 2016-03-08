<?php
/**
 * powered by php-shaman
 * HomeSecondMenu.php 08.03.2016
 * NewFutbolca
 */

namespace frontend\widgets;


class HomeSecondMenu extends \yii\bootstrap\Widget
{

    public $urls = [];

    public function init(){
        parent::init();
    }

    public function run(){

        return $this->render('HomeSecondMenu', [
            'urls' => $this->urls,
        ]);
    }
}