<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use Yii;
use frontend\models\mg\Config;
use frontend\models\HomePage;
use frontend\models\Settings;

class SettingsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = Config::find()->orderBy('config_name asc')->all();
            $homePage = ['sate_off_text', 'footer_text', 'footer_text_2'];
            foreach($models AS $model){
                if(in_array($model->config_name, $homePage)){
                    $settings = new HomePage();
                    $settings->name = $model->config_name;
                    $settings->value = $model->config_value;
                    $settings->title = null;
                    if($settings->validate()){
                        $settings->save();
                    }
                }else{
                    $settings = new Settings();
                    $settings->name = $model->config_name;
                    $settings->value = $model->config_value;
                    $settings->title = null;
                    if($settings->validate()){
                        $settings->save();
                    }
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно!'));
            return $this->refresh();
        }
        return $this->render('index');
    }

}
