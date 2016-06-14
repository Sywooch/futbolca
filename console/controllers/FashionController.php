<?php
/**
 * powered by php-shaman
 * FashionController.php 13.06.2016
 * NewFutbolca
 */

namespace console\controllers;

set_time_limit(0);

use console\models\Fashion;
use console\models\MgBasicsModel;
use Yii;

class FashionController extends \yii\console\Controller // e:\xampp1\php\php.exe yii fashion/index
{
    public function actionIndex()
    {
        $models = MgBasicsModel::find()->orderBy('bm_id asc')->all();
        foreach($models AS $model){
            $fashion = Fashion::find()->where("name = :name", [':name' => $model->bm_name])->one();
            if($fashion){
                continue;
            }
            $fashion = new Fashion();
            $fashion->old = $model->bm_id;
            $fashion->active = 'active';
            $fashion->name = $model->bm_name;
            $fashion->price = $model->bm_price;
            if($fashion->validate()){
                $fashion->save(false);
                echo $model->bm_id.' '.$model->bm_name.PHP_EOL;
            }
        }
        return 0;
    }
}