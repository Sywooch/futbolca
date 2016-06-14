<?php
/**
 * powered by php-shaman
 * ItemController.php 13.06.2016
 * NewFutbolca
 */

namespace console\controllers;

set_time_limit(0);

use console\models\Category;
use console\models\Element;
use console\models\Item;
use console\models\ItemCategory;
use console\models\ItemElement;
use console\models\ItemMarker;
use console\models\ItemPodcategory;
use console\models\ItemWatermark;
use console\models\Marker;
use console\models\MgCategoryLink;
use console\models\MgLinkBasics;
use console\models\MgLinkTags;
use console\models\MgPodcatLink;
use console\models\MgProdact;
use console\models\Podcategory;
use Yii;


class ItemController extends \yii\console\Controller // e:\xampp1\php\php.exe yii item/index
{
    const URL = 'http://futboland.com.ua/';
    const URLSITE = 'http://futboland.com.ua/';

    public function  actionDifference(){ // e:\xampp1\php\php.exe yii item/difference
        $dirToImg = Yii::getAlias('@console/../../uploade/img/');
        $ws = ItemWatermark::find()->orderBy('id asc')->all();
        foreach($ws AS $w){
            if(!$w->hasPhoto()){
                $item = Item::findOne($w->item);
                $item->uploadByConver($dirToImg.$w->name, $w->name);
                $item->uploadByConver($dirToImg.$w->name, $w->name, true);
                echo $w->item.PHP_EOL;
            }
        }
    }

    public function actionIndex($offset = 0)
    {
        $offset = (int)$offset;
        if($offset < 0){
            $offset = 0;
        }
        $models = MgProdact::find()->orderBy('pr_id asc')->offset($offset)->all();

        foreach($models AS $key => $model){
            $oldElement = MgLinkBasics::find()->where("lb_id_tovar = :id", [':id' => $model->pr_id])->one();
            if(!isset($oldElement->lb_id_tovar)){
                continue;
            }
            if(!$oldElement->pr_basics_in_sp){
                $oldElement->pr_basics_in_sp = $oldElement->lb_id_basics;
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
            $order->description = mb_substr($model->pr_description, 0, 255, 'UTF-8');
            $order->keywords = mb_substr($model->pr_keywords, 0, 255, 'UTF-8');;
            $order->price = $model->pr_price;
            $order->active = $model->pr_active ? 1 : 2;
            $order->home = $model->pr_in_home ? 1 : 2;
            $order->toppx = $model->pr_top_px;
            $order->leftpx = $model->pr_left_px;
            $order->text = $model->pr_text;
            if($order->validate()) {
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
                $tags = MgLinkTags::find()->where("lt_id_tovar = :id", [':id' => $model->pr_id])->all();
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
                $cats = MgCategoryLink::find()->where("cl_pid = :id", [':id' => $model->pr_id])->all();
                if($cats){
                    foreach($cats AS $cat){
                        $currentCat = Category::find()->where("old = :old", [':old' => $cat->cl_catid])->one();
                        if(!$currentCat){
                            continue;
                        }
                        $newTag = new ItemCategory();
                        $newTag->item = $order->id;
                        $newTag->category = $currentCat->id;
                        $newTag->save();
                    }
                }
                $podcats = MgPodcatLink::find()->where("pl_pid = :id", [':id' => $model->pr_id])->all();
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
                $elemenets = MgLinkBasics::find()->where("lb_id_tovar = :id AND lb_id_basics <> pr_basics_in_sp", [':id' => $model->pr_id])->all();
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
                echo 'Add '.$key.' -> '.$order->name.' '.PHP_EOL;
            }
        }
    }
}