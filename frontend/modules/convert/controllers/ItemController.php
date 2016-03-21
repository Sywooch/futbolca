<?php

namespace app\modules\convert\controllers;
set_time_limit(0);

use frontend\models\Element;
use frontend\models\Item;
use frontend\models\ItemCategory;
use frontend\models\ItemElement;
use frontend\models\ItemMarker;
use frontend\models\ItemPodcategory;
use frontend\models\ItemWatermark;
use frontend\models\Marker;
use frontend\models\mg\Basics;
use frontend\models\mg\CategoryLink;
use frontend\models\mg\LinkBasics;
use frontend\models\mg\LinkTags;
use frontend\models\mg\Metky;
use frontend\models\mg\PodcatLink;
use frontend\models\mg\Prodact;
use frontend\models\Podcategory;
use Yii;

class ItemController extends \yii\web\Controller
{
    const URL = 'http://futboland.com.ua/';
    const URLSITE = 'http://futboland.com.ua/';

    public function actionIndex($offset = 0)
    {
        if(Yii::$app->request->post('ok')) {
            $offset = (int)$offset;
            if($offset < 0){
                $offset = 0;
            }
            ob_start();
            $models = Prodact::find()->orderBy('pr_id asc')->offset($offset)->all();
            echo 'Start ====== <br>'.PHP_EOL;
            ob_flush();
            flush();
            foreach($models AS $key => $model){
                $oldElement = LinkBasics::find()->where("lb_id_tovar = :id", [':id' => $model->pr_id])->one();;
                if(!isset($oldElement->pr_basics_in_sp)){
                    continue;
                }
                $newElement = Element::find()->where("old = :old", [':old' => $oldElement->pr_basics_in_sp])->one();
                if(!$newElement){
                    continue;
                }
                $order = new Item();
                $order->old = $model->pr_id;
                $order->name = $model->pr_name;
                $order->position = $model->pr_sort;
                $order->url = $model->pr_uri;
                $order->element = $newElement->id;
                $order->code = $model->pr_kode;
                $order->description = $model->pr_description;
                $order->keywords = $model->pr_keywords;
                $order->price = $model->pr_price;
                $order->active = $model->pr_active ? 1 : 2;
                $order->home = $model->pr_in_home ? 1 : 2;
                $order->toppx = $model->pr_top_px;
                $order->leftpx = $model->pr_left_px;
                $order->text = $model->pr_text;
                if($order->validate()) { //.png
                    $order->save(false);
                    $photos = explode('|', $model->pr_wotemark);
                    if(sizeof($photos) > 0){
                        foreach($photos AS $photo){
                            $photoName = trim($photo).'.png';
                            $order->uploadByConver(self::URLSITE.'uploade/img/'.$photoName, $photoName);
                            $order->uploadByConver(self::URLSITE.'uploade/img/'.$photoName, $photoName, true);
                            $itemPhoto = new ItemWatermark();
                            $itemPhoto->item = $order->id;
                            $itemPhoto->name = $photoName;
                            $itemPhoto->save();
                        }
                    }
                    $tags = LinkTags::find()->where("lt_id_tovar = :id", [':id' => $model->pr_id])->all();
                    if($tags){
                        foreach($tags AS $tag){
                            $currentTag = Marker::find()->where("old = :old", [':old' => $tag->lt_id_metky])->one();
                            if(!$currentTag){
                                continue;
                            }
                            $newTag = new ItemMarker();
                            $newTag->item = $order->id;
                            $newTag->marker = $currentTag->id;
                            $newTag->save();
                        }
                    }
                    $cats = CategoryLink::find()->where("cl_pid = :id", [':id' => $model->pr_id])->all();
                    if($cats){
                        foreach($cats AS $cat){
                            $currentCat = \frontend\models\Category::find()->where("old = :old", [':old' => $cat->cl_catid])->one();
                            if(!$currentCat){
                                continue;
                            }
                            $newTag = new ItemCategory();
                            $newTag->item = $order->id;
                            $newTag->category = $currentCat->id;
                            $newTag->save();
                        }
                    }
                    $podcats = PodcatLink::find()->where("pl_pid = :id", [':id' => $model->pr_id])->all();
                    if($podcats){
                        foreach($podcats AS $podcat){
                            $currentPodCat = Podcategory::find()->where("old = :old", [':old' => $podcat->pl_podid])->one();
                            if(!$currentPodCat){
                                continue;
                            }
                            $newTag = new ItemPodcategory();
                            $newTag->item = $order->id;
                            $newTag->podcategory = $currentPodCat->id;
                            $newTag->save();
                        }
                    }
                    $elemenets = LinkBasics::find()->where("lb_id_tovar = :id AND lb_id_basics <> pr_basics_in_sp", [':id' => $model->pr_id])->all();
                    if($elemenets){
                        foreach($elemenets AS $elemenet){
                            $currentElemenet = Element::find()->where("old = :old", [':old' => $elemenet->lb_id_basics])->one();
                            if(!$currentElemenet){
                                continue;
                            }
                            $newTag = new ItemElement();
                            $newTag->item = $order->id;
                            $newTag->element = $currentElemenet->id;
                            $newTag->save();
                        }
                    }

                    echo 'Add '.$order->name.' <br>'.PHP_EOL;
                    ob_flush();
                    flush();
                }else{
                    var_dump($order->getErrors());
                    echo '<br>'.PHP_EOL;
                    ob_flush();
                    flush();
                }
//            if($key > 10){
//                break;
//            }
            }
            echo 'Finish ====== <br>'.PHP_EOL;
            ob_flush();
            flush();
            ob_clean();
        }
        return $this->render('index');
    }

}
