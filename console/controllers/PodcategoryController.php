<?php
/**
 * powered by php-shaman
 * PodcategoryController.php 13.06.2016
 * NewFutbolca
 */

namespace console\controllers;

use console\models\Category;
use console\models\MgPodcat;
use console\models\Podcategory;
use Yii;

class PodcategoryController extends \yii\console\Controller // e:\xampp1\php\php.exe yii podcategory/index
{
    const URL = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        $models = MgPodcat::find()->orderBy('p_id asc')->all();
        foreach($models AS $model){
            $newCat = Category::find()->where("old = :old", [':old' => $model->p_parent])->one();
            if(!$newCat){
                continue;
            }
            $order = Podcategory::find()->where("old = :old", [':old' => $model->p_id])->one();
            if($order){
                continue;
            }
            $order = new Podcategory();
            $order->old = $model->p_id;
            $order->category = $newCat->id;
            $order->position = $model->p_position;
            $order->name = $model->p_name;
            $order->url = $model->p_uri;
            $order->description = $model->p_description;
            $order->keywords = $model->p_keywords;
            $order->text = str_replace([self::URL, '../tags'], ['/', '/tags'], $model->p_text);
            $order->text2 = str_replace([self::URL, '../tags'], ['/', '/tags'], $model->p_text2);
            if($order->validate()) {
                $order->save(false);
                echo $model->p_id.' '.$model->p_name.PHP_EOL;
            }
        }
        return 0;
    }
}