<?php
/**
 * powered by php-shaman
 * NewsController.php 11.06.2016
 * NewFutbolca
 */

namespace console\controllers;

use console\models\MgBlog;
use console\models\News;
use Yii;

class NewsController extends \yii\console\Controller // e:\xampp1\php\php.exe yii news/index
{
    public function actionIndex()
    {
        $models = MgBlog::find()->orderBy('blog_id asc')->all();
        foreach($models AS $model){
            $fashion = News::find()->where("name = :name", [':name' => $model->blog_name])->one();
            if(!$fashion){
                $fashion = new News();
                $fashion->name = $model->blog_name;
                $fashion->url = $model->blog_uri;
                $fashion->description = $model->blog_description;
                $fashion->keywords = $model->blog_keywords;
                $fashion->text = $model->blog_text;
                $fashion->small = $model->blog_smalltext;
                $fashion->created = $model->blog_time ? date("Y-m-d H:i:s", strtotime($model->blog_time)) : date("Y-m-d H:i:s");
                if($fashion->validate()){
                    $fashion->save(false);
                }
            }
        }
    }
}