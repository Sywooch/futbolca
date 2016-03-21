<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use Yii;
Use frontend\models\mg\Dostavka;
Use frontend\models\Delivery;

class DeliveryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = Dostavka::find()->orderBy('do_id asc')->all();
            foreach($models AS $model){
                $fashion = Delivery::find()->where("name = :name", [':name' => $model->do_name])->one();
                if(!$fashion){
                    $fashion = new Delivery();
                    $fashion->old = $model->do_id;
                    $fashion->name = $model->do_name;
                    $fashion->ua = $model->do_ua;
                    $fashion->min = $model->do_min;
                    $fashion->discount = $model->do_discount_ua;
                    $fashion->text = $model->do_desc;
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
