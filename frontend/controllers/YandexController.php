<?php

namespace frontend\controllers;

use frontend\models\Category;
use frontend\models\Item;
use Yii;

class YandexController extends \yii\web\Controller
{
    const TIME = 604800;

    public function actionIndex()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        $key = 'yandexxmlcache';
        $timeCache = self::TIME;
        $data = Yii::$app->cacheFile->get($key);
        if($data === false) {
            $categories = Category::find()->with(['itemCategories'])->orderBy('id asc')->all();
            $items = Item::find()->orderBy('id desc')->where("active = 1")->limit(1000)->all();
            $data = $this->renderPartial('index', [
                'categories' => $categories,
                'items' => $items,
            ]);
            Yii::$app->cacheFile->set($key, $data, $timeCache);
        }
        return $data;
    }
}
