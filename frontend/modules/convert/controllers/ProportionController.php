<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use Yii;
use frontend\models\Proportion;

class ProportionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
            foreach($models AS $model){
                $fashion = Proportion::find()->where("name = :name", [':name' => $model])->one();
                if(!$fashion){
                    $fashion = new Proportion();
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
