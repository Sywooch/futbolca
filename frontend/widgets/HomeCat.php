<?php
/**
 * powered by php-shaman
 * HomeCat.php 08.03.2016
 * NewFutbolca
 */

namespace frontend\widgets;


class HomeCat extends \yii\bootstrap\Widget
{
    public $categories = [];

    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('HomeCat', [
            'categories' => $this->categories,
        ]);
    }
}