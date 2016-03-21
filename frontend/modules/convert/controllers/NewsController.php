<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use Yii;
use frontend\models\mg\Blog;
use frontend\models\News;

class NewsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = Blog::find()->orderBy('blog_id asc')->all();
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
                        $fashion->save();
                    }
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно!'));
            return $this->refresh();
        }
        return $this->render('index');
    }

}
