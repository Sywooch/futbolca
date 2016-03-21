<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use Yii;
use frontend\models\mg\Sp;
use frontend\models\Page;

class PageController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = Sp::find()->orderBy('s_id asc')->all();
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
