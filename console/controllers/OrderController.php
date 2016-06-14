<?php
/**
 * powered by php-shaman
 * OrderController.php 14.06.2016
 * NewFutbolca
 */

namespace console\controllers;

set_time_limit(0);

use console\models\Element;
use console\models\Item;
use console\models\ItemWatermark;
use console\models\MgOrder;
use console\models\Order;
use console\models\OrderItem;
use console\models\Proportion;
use console\models\User;
use Yii;

class OrderController extends \yii\console\Controller // e:\xampp1\php\php.exe yii order/index
{
    const URL = 'http://futboland.com.ua/';
    const URLSITE = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        $models = MgOrder::find()->orderBy('or_id asc')->offset(0)->all();
        foreach($models AS $key => $model){
            $user = User::find()->innerJoin('{{%user_oldid}}', '{{%user_oldid}}.id = {{%user}}.id')->where("{{%user_oldid}}.old = :old", [
                ':old' => $model->or_u_id
            ])->one();
            $order = Order::find()->where("old = :old", [':old' => $model->or_id])->one();
            if($order){
               continue;
            }
            $order = new Order();
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
            }
        }
    }

    protected function trim(& $str){
        $str = trim($str);
        return $str;
    }
}