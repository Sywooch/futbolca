<?php

namespace app\modules\convert\controllers;


set_time_limit(0);

use Yii;
use frontend\models\mg\Category;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = Category::find()->orderBy('c_id asc')->all();
            foreach($models AS $model){
                $order = new \frontend\models\Category();
                $order->old = $model->c_id;
                $order->position = $model->c_position;
                $order->name = $model->c_name;
                $order->url = $model->c_uri;
                $order->description = $model->c_description;
                $order->keywords = $model->c_keywords;
                $order->text = str_replace(['http://futboland.com.ua/', '../tags'], ['/', '/tags'], $model->c_text);
                $order->text2 = str_replace(['http://futboland.com.ua/', '../tags'], ['/', '/tags'], $model->c_text2);
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
