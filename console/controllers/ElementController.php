<?php
/**
 * powered by php-shaman
 * ElementController.php 13.06.2016
 * NewFutbolca
 */

namespace console\controllers;

set_time_limit(0);

use console\models\Element;
use console\models\ElementSize;
use console\models\Fashion;
use console\models\MgBasics;
use console\models\Proportion;
use Yii;


class ElementController extends \yii\console\Controller // e:\xampp1\php\php.exe yii element/index
{
    const URL = 'http://futboland.com.ua/';
    const URLSITE = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        $dirToImg = Yii::getAlias('@console/../../uploade/img/');
        $models = MgBasics::find()->orderBy('bs_id asc')->all();
        foreach($models AS $model){
            $newF = Fashion::find()->where("old = :old", [':old' => $model->bm_id])->one();
            $sizes = explode('|', $model->bs_size);
            $order = new Element();
            $order->old = $model->bs_id;
            $order->stock = $model->bs_insclad;
            $order->name = $model->bs_name;
            $order->home = $model->bs_home ? 1 : 2;
            $order->fashion = $newF->id;
            $order->toppx = $model->b_top_px;
            $order->leftpx = $model->b_left_px;
            $order->price = 0;
            $order->increase = $model->b_price;
            $order->photo = $model->bs_photo.'.jpg';
            if($order->validate()) {
                $order->save(false);
                $order->uploadByConver($dirToImg.$order->photo);
                $order->uploadByConver($dirToImg.$order->photo, true);
                if(sizeof($sizes) > 0){
                    foreach($sizes AS $size){
                        $size = trim($size);
                        $currentSize = Proportion::find()->where("name = :name", [':name' => $size])->one();
                        if(!$currentSize){
                            continue;
                        }
                        $newSize = new ElementSize();
                        $newSize->element = $order->id;
                        $newSize->size = $currentSize->id;
                        $newSize->save();
                    }
                }
                echo $model->bs_id.' '.$model->bs_name.PHP_EOL;
            }

        }
        return 0;
    }

    protected function urlExists($url) {
        $hdrs = @get_headers($url);
        return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
    }
}