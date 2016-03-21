<?php

namespace app\modules\convert\controllers;


set_time_limit(0);

use Yii;
use frontend\models\mg\Podcat;
use frontend\models\Category;
use frontend\models\Podcategory;

class PodcategoryController extends \yii\web\Controller
{
    const URL = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = Podcat::find()->orderBy('p_id asc')->all();
            foreach($models AS $model){
                $newCat = Category::find()->where("old = :old", [':old' => $model->p_parent])->one();
                $order = new Podcategory();
                $order->old = $model->p_id;
                $order->category = $newCat->id;
                $order->position = $model->p_position;
                $order->name = $model->p_name;
                $order->url = $model->p_uri;
                $order->description = $model->p_description;
                $order->keywords = $model->p_keywords;
                $order->text = str_replace([self::URL, '../tags'], ['/', '/tags'], $model->p_text);
                $order->text2 = str_replace([self::URL, '../tags'], ['/', '/tags'], $model->p_text2);
                if($order->validate()) {
                    $order->save();
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно!'));
            return $this->refresh();
        }
        return $this->render('index');
    }

}
