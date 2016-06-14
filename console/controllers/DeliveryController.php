<?php
/**
 * powered by php-shaman
 * DeliveryController.php 10.06.2016
 * NewFutbolca
 */

namespace console\controllers;

use console\models\Delivery;
use console\models\MgDostavka;
use Yii;

class DeliveryController extends \yii\console\Controller // e:\xampp1\php\php.exe yii delivery/index
{
    public function actionIndex()
    {
        $models = MgDostavka::find()->orderBy('do_id asc')->all();
        foreach($models AS $model){
            $fashion = Delivery::find()->where("name = :name", [':name' => $model->do_name])->one();
            if(!$fashion){
                $fashion = new Delivery();
                $fashion->old = $model->do_id;
                $fashion->name = $model->do_name;
                $fashion->ua = $model->do_ua;
                $fashion->min = $model->do_min;
                $fashion->discount = $model->do_discount_ua;
                $fashion->text = $model->do_desc;
                if($fashion->validate()){
                    $fashion->save(false);
                }
            }
        }
    }
}