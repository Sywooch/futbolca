<?php
/**
 * powered by php-shaman
 * CategoryController.php 13.06.2016
 * NewFutbolca
 */

namespace console\controllers;

use console\models\Category;
use console\models\MgCategory;
use Yii;


class CategoryController extends \yii\console\Controller // e:\xampp1\php\php.exe yii category/index
{
    const URL = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        $models = MgCategory::find()->orderBy('c_id asc')->all();
        foreach($models AS $model){
            $order = Category::find()->where("old = :old", [':old' => $model->c_id])->one();
            if($order){
                continue;
            }
            $order = new Category();
            $order->old = $model->c_id;
            $order->position = $model->c_position;
            $order->name = $model->c_name;
            $order->url = $model->c_uri;
            $order->description = $model->c_description;
            $order->keywords = $model->c_keywords;
            $order->text = str_replace([self::URL, '../tags'], ['/', '/tags'], $model->c_text);
            $order->text2 = str_replace([self::URL, '../tags'], ['/', '/tags'], $model->c_text2);
            if($order->validate()) {
                $order->save(false);
                echo $model->c_id.' '.$model->c_name.PHP_EOL;
            }
        }
        return 0;
    }
}