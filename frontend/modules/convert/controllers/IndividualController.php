<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use Yii;
use frontend\models\IndividualConvert;
use frontend\models\mg\IndividualOrder;

class IndividualController extends \yii\web\Controller
{
    const URLSITE = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')){
            $models = IndividualOrder::find()->orderBy('io_id asc')->all();
            ob_start();
            echo 'Start<br>'.PHP_EOL;
            ob_flush();
            flush();
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
                if($this->urlExists(self::URLSITE.'uploade/individualphoto/'.$model->io_id.'_0.jpg')){
                    $order->img1 = $model->io_id.'_0.jpg';
                }
                if($this->urlExists(self::URLSITE.'uploade/individualphoto/'.$model->io_id.'_1.jpg')){
                    $order->img2 = $model->io_id.'_1.jpg';
                }
                if($this->urlExists(self::URLSITE.'uploade/individualphoto/'.$model->io_id.'_2.jpg')){
                    $order->img3 = $model->io_id.'_2.jpg';
                }
                if($this->urlExists(self::URLSITE.'uploade/individualphoto/'.$model->io_id.'_3.jpg')){
                    $order->img4 = $model->io_id.'_3.jpg';
                }
                $order->admintext = $model->io_admintext;
                $order->created = date("Y-m-d H:i:s", $model->io_date);
                if($order->validate()){
                    $order->save(false);
                    if($order->img1){
                        $order->uploadForConvert(self::URLSITE.'uploade/individualphoto/'.$model->io_id.'_0.jpg', $order->img1);
                    }
                    if($order->img2){
                        $order->uploadForConvert(self::URLSITE.'uploade/individualphoto/'.$model->io_id.'_1.jpg', $order->img2);
                    }
                    if($order->img3){
                        $order->uploadForConvert(self::URLSITE.'uploade/individualphoto/'.$model->io_id.'_2.jpg', $order->img3);
                    }
                    if($order->img4){
                        $order->uploadForConvert(self::URLSITE.'uploade/individualphoto/'.$model->io_id.'_3.jpg', $order->img4);
                    }
                    echo $order->id.'<br>'.PHP_EOL;
                    ob_flush();
                    flush();
                }else{
                    var_dump($order->getErrors());
                    ob_flush();
                    flush();
                }
            }
            echo 'Finish<br>'.PHP_EOL;
            ob_flush();
            flush();
            ob_clean();
//            Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно!'));
//            return $this->refresh();
        }
        return $this->render('index');
    }


    protected function urlExists($url) {
        $hdrs = @get_headers($url);
        return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
    }
}
