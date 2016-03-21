<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use Yii;
use frontend\models\mg\Metky;
use frontend\models\Marker;

class MarkerController extends \yii\web\Controller
{
    const URL = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = Metky::find()->orderBy('mt_id asc')->all();
            foreach($models AS $model){
                $fashion = Marker::find()->where("name = :name", [':name' => $model->mt_name])->one();
                if(!$fashion){
                    $fashion = new Marker();
                    $fashion->old = $model->mt_id;
                    $fashion->name = $model->mt_name;
                    $fashion->url = $model->mt_uri;
                    $fashion->description = $model->mt_description;
                    $fashion->keywords = $model->mt_keywords;
                    $fashion->text = $model->mt_text;
                    $fashion->text2 = $model->mt_text2;
                    if($fashion->validate()){
                        $fashion->save(false);
                    }
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно!'));
            return $this->refresh();
        }
        return $this->render('index');
    }

}
