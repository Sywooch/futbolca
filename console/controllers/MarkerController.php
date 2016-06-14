<?php
/**
 * powered by php-shaman
 * MarkerController.php 11.06.2016
 * NewFutbolca
 */

namespace console\controllers;

use console\models\Marker;
use console\models\MgMetky;
use Yii;

class MarkerController extends \yii\console\Controller // e:\xampp1\php\php.exe yii marker/index
{
    public function actionIndex()
    {
        $models = MgMetky::find()->orderBy('mt_id asc')->all();
        foreach($models AS $model){
            $fashion = Marker::find()->where("name = :name", [':name' => $model->mt_name])->one();
            if(!$fashion){
                $fashion = new Marker();
                $fashion->old = $model->mt_id;
                $fashion->name = $model->mt_name;
                $fashion->url = $model->mt_uri;
                $fashion->description = $model->mt_description;
                $fashion->keywords = $model->mt_keywords;
                $fashion->text = str_replace(['../../css/images/', '../css/images/'], ['/images/page/', '/images/page/'], $model->mt_text);
                $fashion->text2 = str_replace(['../../css/images/', '../css/images/'], ['/images/page/', '/images/page/'], $model->mt_text2);
                if($fashion->validate()){
                    $fashion->save(false);
                    echo $model->mt_id.' '.$model->mt_name.PHP_EOL;
                }
            }
        }
        return 0;
    }
}