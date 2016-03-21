<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use Yii;
use frontend\models\mg\BasicsModel;
use frontend\models\Fashion;

class FashionController extends \yii\web\Controller
{
    const URL = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = BasicsModel::find()->orderBy('bm_id asc')->all();
            foreach($models AS $model){
                $fashion = Fashion::find()->where("name = :name", [':name' => $model->bm_name])->one();
                if(!$fashion){
                    $fashion = new Fashion();
                    $fashion->old = $model->bm_id;
                    $fashion->active = 'active';
                    $fashion->name = $model->bm_name;
                    $fashion->price = $model->bm_price;
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
