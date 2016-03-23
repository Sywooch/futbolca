<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use frontend\models\Element;
use frontend\models\Item;
use frontend\models\ItemWatermark;
use frontend\models\mg\Order;
use frontend\models\OrderItem;
use frontend\models\Proportion;
use frontend\models\User;
use Yii;

class OrderController extends \yii\web\Controller
{
    const URL = 'http://futboland.com.ua/';
    const URLSITE = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')) {
            ob_start();
            $models = Order::find()->orderBy('or_id asc')->offset(23985)->limit(10000)->all();
            echo sizeof($models).' Start ====== <br>'.PHP_EOL;
            ob_flush();
            flush();
            foreach($models AS $key => $model){
                $user = User::find()->innerJoin('{{%user_oldid}}', '{{%user_oldid}}.id = {{%user}}.id')->where("{{%user_oldid}}.old = :old", [
                    ':old' => $model->or_u_id
                ])->one();

                $order = new \frontend\models\Order();
                $order->old = $model->or_id;
                $order->name = $model->or_u_name ? $model->or_u_name : '-';
                $order->data_start = date("Y-m-d H:i:s", $model->or_data_start);
                $order->data_finish = date("Y-m-d H:i:s", $model->or_data_finish);
                $order->user = isset($user->id) ? $user->id : 0;
                $order->code = $model->or_u_index;
                $order->soname = $model->or_u_soname;
                $order->email = $model->or_u_email ? $model->or_u_email : 'not@email.com';
                $order->phone = $model->or_u_phone ? $model->or_u_phone : 'нет телефона';
                $order->adress = $model->or_u_adress ? $model->or_u_adress : '-';
                $order->city = $model->or_u_city;
                $order->country = $model->or_u_country;
                $order->payment = (int)$model->or_payment;
                $order->delivery = (int)$model->or_dostavkainajax;
                $order->agent = $model->or_u_agent;
                $order->region = $model->or_u_region;
                $order->fax = $model->or_u_fax;
                $order->icq = $model->or_u_icq;
                $order->skape = $model->or_u_skape;
                $order->status = (int)$model->or_status;
                $order->coment_admin = $model->or_coment_admin;
                if($order->validate()){
                    $order->save(false);
                    $images = explode('||', $model->or_nabor_tovara);
                    if(sizeof($images) > 0){
                        foreach($images AS $image){
                            $image = explode('/%/', $image);
                            array_walk($image, [$this, 'trim']);
                            $item = Item::find()->where("old = :old", [':old' => (int)$image[0]])->one();
                            if(!$item){
                                continue;
                            }
                            $sizeCurrent = Proportion::find()->where("name = :name", [':name' => $image[6]])->one();
                            if(!$sizeCurrent){
                                continue;
                            }
                            $newElement = Element::find()->where("old = :old", [':old' => (int)$image[4]])->one();
                            if(!$newElement){
                                continue;
                            }
                            $watermarkWhere = $image[5].'.png';
                            $watermark = ItemWatermark::find()->where("name = :name", [':name' => $watermarkWhere])->one();
                            if(!$watermark){
                                $watermark = isset($item->itemWatermarks[0]) ? $item->itemWatermarks[0] : null;
                            }
                            $orderItem = new OrderItem();
                            $orderItem->orders = $order->id;
                            $orderItem->element = $newElement->id;
                            $orderItem->item = $item->id;
                            $orderItem->counts = (int)$image[1];
                            $orderItem->price = (int)$image[2];
                            $orderItem->watermark = isset($watermark->id) ? $watermark->id : null;
                            $orderItem->size = $sizeCurrent->id;
                            if($orderItem->validate()) {
                                $orderItem->save(false);
                            }
                        }
                    }
                    echo $order->id.' Add <br>'.PHP_EOL;
                    ob_flush();
                    flush();
                }
            }
            echo 'Finish ====== <br>'.PHP_EOL;
            ob_flush();
            flush();
            ob_clean();
        }
        return $this->render('index');
    }

    protected function trim(& $str){
        $str = trim($str);
        return $str;
    }

}
