<?php
/**
 * powered by php-shaman
 * SettingsController.php 10.06.2016
 * NewFutbolca
 */

namespace console\controllers;

use console\models\HomePage;
use console\models\MgConfig;
use console\models\Settings;
use Yii;


class SettingsController extends \yii\console\Controller // e:\xampp1\php\php.exe yii settings/index
{
    public function actionIndex() {
        $models = MgConfig::find()->orderBy('config_name asc')->all();
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
    }
}