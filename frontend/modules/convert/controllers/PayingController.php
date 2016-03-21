<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use Yii;
use frontend\models\Paying;

class PayingController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = ['Оплата при получении', 'Предоплата (Webmoney, Приват24, карта Приватбанка)'];
            foreach($models AS $model){
                $fashion = Paying::find()->where("name = :name", [':name' => $model])->one();
                if(!$fashion){
                    $fashion = new Paying();
                    $fashion->name = $model;
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
