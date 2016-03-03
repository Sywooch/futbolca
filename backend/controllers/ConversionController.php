<?php

namespace backend\controllers;

set_time_limit(0);


use backend\models\Delivery;
use backend\models\Element;
use backend\models\ElementSize;
use backend\models\Fashion;
use backend\models\HomePage;
use backend\models\Individual;
use backend\models\Item;
use backend\models\ItemCategory;
use backend\models\ItemElement;
use backend\models\ItemMarker;
use backend\models\ItemPodcategory;
use backend\models\ItemWatermark;
use backend\models\Marker;
use backend\models\News;
use backend\models\old\Basics;
use backend\models\old\BasicsModel;
use backend\models\old\Blog;
use backend\models\old\Category;
use backend\models\old\Config;
use backend\models\old\Dostavka;
use backend\models\old\IndividualOrder;
use backend\models\old\LinkBasics;
use backend\models\old\Metky;
use backend\models\old\Order;
use backend\models\old\Podcat;
use backend\models\old\PodcatLink;
use backend\models\old\Prodact;
use backend\models\old\Sp;
use backend\models\OrderItem;
use backend\models\Page;
use backend\models\Paying;
use backend\models\Podcategory;
use backend\models\Proportion;
use backend\models\Settings;
use common\UrlHelper;
use yii\widgets\Block;

class ConversionController extends \backend\ext\BaseController
{

    const URLSITE = 'http://futboland.com.ua/';

    public function actionIndex()
    {

        return $this->render('index');
    }

    // [0] id item
    // [1] id count
    // [2] id price
    // [3] id price

    // [4] id basics
    // [5] id img
    // [6] id size


//SET foreign_key_checks = 0;
//TRUNCATE `fl_order`;
//TRUNCATE `fl_order_item`;
//SET foreign_key_checks = 1;
    public function actionOrder() // or_nabor_tovara 1157/%/1/%/125/%/125.00/%/11/%/0300037001358876779/%/XL||1158/%/1/%/125/%/125.00/%/24/%/0491108001358877035/%/S
    {
        $models = Order::find()->orderBy('or_id asc')->offset(0)->all();
        foreach($models AS $key => $model){
            $order = new \backend\models\Order();
            $order->name = $model->or_u_name ? $model->or_u_name : '-';
            $order->data_start = date("Y-m-d H:i:s", $model->or_data_start);
            $order->data_finish = date("Y-m-d H:i:s", $model->or_data_finish);
            $order->user = $model->or_u_id;
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
                $order->save();
                $images = explode('||', $model->or_nabor_tovara);
                if(sizeof($images) > 0){
                    foreach($images AS $image){
                        $image = explode('/%/', $image);
                        $sizeCurrent = Proportion::find()->where("name = :name", [':name' => $image[6]])->one();
                        if(!$sizeCurrent){
                            continue;
                        }
                        $oldElement = Basics::find()->where("bs_id = :id", [':id' => (int)$image[4]])->one();
                        if(!$oldElement){
                            continue;
                        }
                        $newElement = Element::find()->where("name = :name", [':name' => $oldElement->bs_name])->one();
                        if(!$newElement){
                            continue;
                        }
                        $orderItem = new OrderItem();
                        $orderItem->orders = $order->id;
                        $orderItem->element = $newElement->id;
                        $orderItem->item = (int)$image[0];
                        $orderItem->counts = (int)$image[1];
                        $orderItem->price = (int)$image[2];
                        $orderItem->size = $sizeCurrent->id;
                        if($orderItem->validate()) {
                            $orderItem->save();
                        }
                    }
                }
            }
//            if($key > 2){
//                break;
//            }
        }
    }

    public function actionItem($offset = 0)
    {
        $offset = (int)$offset;
        if($offset < 0){
            $offset = 0;
        }
        ob_start();
        $models = Prodact::find()->orderBy('pr_id asc')->offset(0)->all();
        echo 'Start ====== <br>'.PHP_EOL;
        ob_flush();
        flush();
        foreach($models AS $key => $model){
            $oldElement = Basics::find()
                ->innerJoin('mg_link_basics', 'mg_basics.bs_id = mg_link_basics.pr_basics_in_sp')
                ->where("mg_link_basics.lb_id_tovar = :id", [':id' => $model->pr_id])->one();
            if(!isset($oldElement->bs_name)){
                continue;
            }
            $newElement = Element::find()->where("name = :name", [':name' => $oldElement->bs_name])->one();
            if(!$newElement){
               continue;
            }
            $order = new Item();
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
                $order->save();
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
                $tags = Metky::find()
                    ->innerJoin('mg_link_tags', 'mg_link_tags.lt_id_metky = mg_metky.mt_id')
                    ->where("mg_link_tags.lt_id_tovar = :id", [':id' => $model->pr_id])->all();
                if($tags){
                    foreach($tags AS $tag){
                        $currentTag = Marker::find()->where("name = :name", [':name' => $tag->mt_name])->one();
                        if(!$currentTag){
                            continue;
                        }
                        $newTag = new ItemMarker();
                        $newTag->item = $order->id;
                        $newTag->marker = $currentTag->id;
                        $newTag->save();
                    }
                }
                $cats = Category::find()
                    ->innerJoin('mg_category_link', 'mg_category_link.cl_catid = mg_category.c_id')
                    ->where("mg_category_link.cl_pid = :id", [':id' => $model->pr_id])->all();
                if($cats){
                    foreach($cats AS $cat){
                        $currentCat = \backend\models\Category::find()->where("name = :name", [':name' => $cat->c_name])->one();
                        if(!$currentCat){
                            continue;
                        }
                        $newTag = new ItemCategory();
                        $newTag->item = $order->id;
                        $newTag->category = $currentCat->id;
                        $newTag->save();
                    }
                }
                $podcats = Podcat::find()
                    ->innerJoin('mg_podcat_link', 'mg_podcat_link.pl_podid = mg_podcat.p_id')
                    ->where("mg_podcat_link.pl_pid = :id", [':id' => $model->pr_id])->all();
                if($podcats){
                    foreach($podcats AS $podcat){
                        $currentPodCat = Podcategory::find()->where("name = :name", [':name' => $podcat->p_name])->one();
                        if(!$currentPodCat){
                            continue;
                        }
                        $newTag = new ItemPodcategory();
                        $newTag->item = $order->id;
                        $newTag->podcategory = $currentPodCat->id;
                        $newTag->save();
                    }
                }
                $elemenets = Basics::find()
                    ->innerJoin('mg_link_basics', 'mg_link_basics.lb_id_basics = mg_basics.bs_id')
                    ->where("mg_link_basics.lb_id_tovar = :id AND mg_link_basics.lb_id_basics <> mg_link_basics.pr_basics_in_sp", [':id' => $model->pr_id])->all();
                if($elemenets){
                    foreach($elemenets AS $elemenet){
                        $currentElemenet = Element::find()->where("name = :name", [':name' => $elemenet->bs_name])->one();
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

    public function actionElement()
    {
        $models = Basics::find()->orderBy('bs_id asc')->all();
        foreach($models AS $model){
            $parant = BasicsModel::find()->where("bm_id = :id", [':id' => $model->bm_id])->one();
            $newF = Fashion::find()->where("name = :name", [':name' => $parant->bm_name])->one();
            $sizes = explode('|', $model->bs_size);
            $order = new Element();
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
                $order->save();
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
    }

    public function actionPodcategory()
    {
        $models = Podcat::find()->orderBy('p_id asc')->all();
        foreach($models AS $model){
            $oldCat = Category::find()->where("c_id = :id", [':id' => $model->p_parent])->one();
            $newCat = \backend\models\Category::find()->where("url = :url", [':url' => $oldCat->c_uri])->one();
            $order = new Podcategory();
            $order->category = $newCat->id;
            $order->position = $model->p_position;
            $order->name = $model->p_name;
            $order->url = $model->p_uri;
            $order->description = $model->p_description;
            $order->keywords = $model->p_keywords;
            $order->text = str_replace(['http://futboland.com.ua/', '../tags'], ['/', '/tags'], $model->p_text);
            $order->text2 = str_replace(['http://futboland.com.ua/', '../tags'], ['/', '/tags'], $model->p_text2);
            if($order->validate()) {
                $order->save();
            }
        }
    }

    public function actionCategory()
    {
        $models = Category::find()->orderBy('c_id asc')->all();
        foreach($models AS $model){
            $order = new \backend\models\Category();
            $order->position = $model->c_position;
            $order->name = $model->c_name;
            $order->url = $model->c_uri;
            $order->description = $model->c_description;
            $order->keywords = $model->c_keywords;
            $order->text = str_replace(['http://futboland.com.ua/', '../tags'], ['/', '/tags'], $model->c_text);
            $order->text2 = str_replace(['http://futboland.com.ua/', '../tags'], ['/', '/tags'], $model->c_text2);
            if($order->validate()) {
                $order->save();
            }
        }
    }

    public function actionIndividual()
    {
        $models = IndividualOrder::find()->orderBy('io_id asc')->all();
        ob_start();
        echo 'Start<br>'.PHP_EOL;
        ob_flush();
        flush();
        foreach($models AS $model){
            $order = new Individual();
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
                $order->save();
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
    }

    public function actionSettings()
    {
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
    }

    public function actionPage()
    {
        $models = Sp::find()->orderBy('s_id asc')->all();
        foreach($models AS $model){
            $fashion = Page::find()->where("name = :name", [':name' => $model->s_name])->one();
            if(!$fashion){
                $fashion = new Page();
                $fashion->name = $model->s_name;
                $fashion->url = $model->s_uri;
                $fashion->description = $model->s_description;
                $fashion->keywords = $model->s_keywords;
                $fashion->text = str_replace(['../../css/images/', '../css/images/'], ['/images/page/', '/images/page/'], $model->s_text);
                if($fashion->validate()){
                    $fashion->save();
                }
            }
        }
        return $this->render('index');
    }

    public function actionProportion()
    {
        $models = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
        foreach($models AS $model){
            $fashion = Proportion::find()->where("name = :name", [':name' => $model])->one();
            if(!$fashion){
                $fashion = new Proportion();
                $fashion->name = $model;
                if($fashion->validate()){
                    $fashion->save();
                }
            }
        }
        return $this->render('index');
    }

    public function actionPaying()
    {
        $models = ['Оплата при получении', 'Предоплата'];
        foreach($models AS $model){
            $fashion = Paying::find()->where("name = :name", [':name' => $model])->one();
            if(!$fashion){
                $fashion = new Paying();
                $fashion->name = $model;
                if($fashion->validate()){
                    $fashion->save();
                }
            }
        }
        return $this->render('index');
    }

    public function actionDelivery()
    {
        $models = Dostavka::find()->orderBy('do_id asc')->all();
        foreach($models AS $model){
            $fashion = Delivery::find()->where("name = :name", [':name' => $model->do_name])->one();
            if(!$fashion){
                $fashion = new Delivery();
                $fashion->name = $model->do_name;
                $fashion->ua = $model->do_ua;
                $fashion->min = $model->do_min;
                $fashion->discount = $model->do_discount_ua;
                $fashion->text = $model->do_desc;
                if($fashion->validate()){
                    $fashion->save();
                }
            }
        }
        return $this->render('index');
    }

    public function actionNews()
    {
        $models = Blog::find()->orderBy('blog_id asc')->all();
        foreach($models AS $model){
            $fashion = News::find()->where("name = :name", [':name' => $model->blog_name])->one();
            if(!$fashion){
                $fashion = new News();
                $fashion->name = $model->blog_name;
                $fashion->url = $model->blog_uri;
                $fashion->description = $model->blog_description;
                $fashion->keywords = $model->blog_keywords;
                $fashion->text = $model->blog_text;
                $fashion->small = $model->blog_smalltext;
                $fashion->created = $model->blog_time ? date("Y-m-d H:i:s", strtotime($model->blog_time)) : date("Y-m-d H:i:s");
                if($fashion->validate()){
                    $fashion->save();
                }
            }
        }
        return $this->render('index');
    }

    public function actionFashion()
    {
        $models = BasicsModel::find()->orderBy('bm_id asc')->all();
        foreach($models AS $model){
            $fashion = Fashion::find()->where("name = :name", [':name' => $model->bm_name])->one();
            if(!$fashion){
                $fashion = new Fashion();
                $fashion->active = 'active';
                $fashion->name = $model->bm_name;
                $fashion->price = $model->bm_price;
                if($fashion->validate()){
                    $fashion->save();
                }
            }
        }
        return $this->render('index');
    }

    public function actionMarker()
    {
        $models = Metky::find()->orderBy('mt_id asc')->all();
        foreach($models AS $model){
            $fashion = Marker::find()->where("name = :name", [':name' => $model->mt_name])->one();
            if(!$fashion){
                $fashion = new Marker();
                $fashion->name = $model->mt_name;
                $fashion->url = $model->mt_uri;
                $fashion->description = $model->mt_description;
                $fashion->keywords = $model->mt_keywords;
                $fashion->text = $model->mt_text;
                $fashion->text2 = $model->mt_text2;
                if($fashion->validate()){
                    $fashion->save();
                }
            }
        }
        return $this->render('index');
    }

    protected function urlExists($url) {
        $hdrs = @get_headers($url);
        return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
    }
}
