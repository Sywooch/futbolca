<?php
/**
 * powered by php-shaman
 * HomeNews.php 08.03.2016
 * NewFutbolca
 */

namespace frontend\widgets;


use frontend\models\News;

class HomeNews extends \yii\bootstrap\Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        $model = News::find()->orderBy('id desc')->limit(1)->one();
        return $this->render('HomeNews', [
            'model' => $model
        ]);
    }
}