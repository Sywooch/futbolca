<?php
/**
 * powered by php-shaman
 * PayingController.php 11.06.2016
 * NewFutbolca
 */

namespace console\controllers;

use console\models\Paying;
use Yii;

class PayingController extends \yii\console\Controller // e:\xampp1\php\php.exe yii paying/index
{
    public function actionIndex() {
        $payings = [];
        $payings[] = [
            'name' => 'Оплата при получении',
            'text' => '',
        ];
        $payings[] = [
            'name' => 'Предоплата (Webmoney, Приват24, карта Приватбанка)',
            'text' => '',
        ];
        foreach($payings AS $paying){
            $model = Paying::find()->where("name = :name", [':name' => $paying['name']])->one();
            if(!$model){
                $model = new Paying();
                $model->name = $paying['name'];
                $model->text = $paying['text'];
                $model->save();
            }
        }
    }
}