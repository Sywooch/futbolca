<?php
/**
 * powered by php-shaman
 * IndividualController.php 13.06.2016
 * NewFutbolca
 */

namespace console\controllers;

set_time_limit(0);

use console\models\IndividualConvert;
use console\models\MgIndividualOrder;
use Yii;

class IndividualController extends \yii\console\Controller // e:\xampp1\php\php.exe yii individual/index
{
    const URLSITE = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        $dirToImg = Yii::getAlias('@console/../../uploade/individualphoto/');
        $models = MgIndividualOrder::find()->orderBy('io_id asc')->all();
        foreach($models AS $model){
            $order = IndividualConvert::find()->where("old = :old", [':old' => $model->io_id])->one();
            if($order){
                continue;
            }
            $order = new IndividualConvert();
            $order->old = $model->io_id;
            $order->name = $model->io_name ? $model->io_name : 'нет имени';
            $order->status = (int)$model->io_status;
            $order->phone = $model->io_phone ? $model->io_phone : 'нет телефона';
            $order->email = $model->io_email ? $model->io_email : 'not@email.com';
            $order->comment = $model->io_text;
            if($this->urlExists($dirToImg.$model->io_id.'_0.jpg')){
                $order->img1 = $model->io_id.'_0.jpg';
            }
            if($this->urlExists($dirToImg.$model->io_id.'_1.jpg')){
                $order->img2 = $model->io_id.'_1.jpg';
            }
            if($this->urlExists($dirToImg.$model->io_id.'_2.jpg')){
                $order->img3 = $model->io_id.'_2.jpg';
            }
            if($this->urlExists($dirToImg.$model->io_id.'_3.jpg')){
                $order->img4 = $model->io_id.'_3.jpg';
            }
            $order->admintext = $model->io_admintext;
            $order->created = date("Y-m-d H:i:s", $model->io_date);
            if($order->validate()){
                $order->save(false);
                if($order->img1){
                    $order->uploadForConvert($dirToImg.$model->io_id.'_0.jpg', $order->img1);
                }
                if($order->img2){
                    $order->uploadForConvert($dirToImg.$model->io_id.'_1.jpg', $order->img2);
                }
                if($order->img3){
                    $order->uploadForConvert($dirToImg.$model->io_id.'_2.jpg', $order->img3);
                }
                if($order->img4){
                    $order->uploadForConvert($dirToImg.$model->io_id.'_3.jpg', $order->img4);
                }
                echo $order->id.PHP_EOL;
            }else{
                var_dump($order->getErrors());
            }
        }
    }


    protected function urlExists($url) {
        return file_exists($url);
    }
}