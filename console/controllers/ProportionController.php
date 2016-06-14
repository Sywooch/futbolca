<?php
/**
 * powered by php-shaman
 * ProportionController.php 11.06.2016
 * NewFutbolca
 */

namespace console\controllers;

use console\models\Proportion;
use Yii;

class ProportionController extends \yii\console\Controller // e:\xampp1\php\php.exe yii proportion/index
{
    public function actionIndex()
    {
        $models = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
        foreach($models AS $model){
            $fashion = Proportion::find()->where("name = :name", [':name' => $model])->one();
            if(!$fashion){
                $fashion = new Proportion();
                $fashion->name = $model;
                if($fashion->validate()){
                    $fashion->save(false);
                }
            }
        }
    }
}