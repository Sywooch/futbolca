<?php
/**
 * powered by php-shaman
 * PageController.php 10.06.2016
 * NewFutbolca
 */

namespace console\controllers;

use console\models\MgSp;
use console\models\Page;
use Yii;

class PageController extends \yii\console\Controller // e:\xampp1\php\php.exe yii page/index
{
    public function actionIndex() {
        $models = MgSp::find()->orderBy('s_id asc')->all();
        foreach($models AS $model){
            $fashion = Page::find()->where("name = :name", [':name' => $model->s_name])->one();
            if(!$fashion){
                $fashion = new Page();
                $fashion->name = $model->s_name;
                $fashion->url = $model->s_uri;
                $fashion->description = $model->s_description;
                $fashion->keywords = $model->s_keywords;
                $fashion->text = str_replace(['../../css/images/', '../css/images/'], ['/images/page/', '/images/page/'], $model->s_text);
                if($fashion->validate()){
                    $fashion->save(false);
                }
            }
        }
    }
}