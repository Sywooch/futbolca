<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use Yii;
use frontend\models\mg\Basics;
use frontend\models\Element;
use frontend\models\Fashion;
use frontend\models\Proportion;
use frontend\models\ElementSize;

class ElementController extends \yii\web\Controller
{
    const URL = 'http://futboland.com.ua/';
    const URLSITE = 'http://futboland.com.ua/';

    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')) {
            $models = Basics::find()->orderBy('bs_id asc')->all();
            foreach($models AS $model){
                $newF = Fashion::find()->where("old = :old", [':old' => $model->bm_id])->one();
                $sizes = explode('|', $model->bs_size);
                $order = new Element();
                $order->old = $model->bs_id;
                $order->stock = $model->bs_insclad;
                $order->name = $model->bs_name;
                $order->home = $model->bs_home ? 1 : 2;
                $order->fashion = $newF->id;
                $order->toppx = $model->b_top_px;
                $order->leftpx = $model->b_left_px;
                $order->price = 0;
                $order->increase = $model->b_price;
                $order->photo = $model->bs_photo.'.jpg';
                if($order->validate()) {
                    $order->save(false);
                    $order->uploadByConver(self::URLSITE.'uploade/img/'.$order->photo);
                    $order->uploadByConver(self::URLSITE.'uploade/img/'.$order->photo, true);
                    if(sizeof($sizes) > 0){
                        foreach($sizes AS $size){
                            $size = trim($size);
                            $currentSize = Proportion::find()->where("name = :name", [':name' => $size])->one();
                            if(!$currentSize){
                                continue;
                            }
                            $newSize = new ElementSize();
                            $newSize->element = $order->id;
                            $newSize->size = $currentSize->id;
                            $newSize->save();
                        }
                    }
                }

            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно!'));
            return $this->refresh();
        }
        return $this->render('index');
    }

    protected function urlExists($url) {
        $hdrs = @get_headers($url);
        return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
    }
}
