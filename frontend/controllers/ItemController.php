<?php

namespace frontend\controllers;

use frontend\models\Element;
use frontend\models\Fashion;
use frontend\models\Item;
use frontend\models\Proportion;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use Yii;


class ItemController extends \yii\web\Controller
{
    const TIME = 3600;
    const TIMEAJAX = 3600;

    public function actionBlock()
    {
        if(!Yii::$app->request->isAjax){
            throw new BadRequestHttpException(Yii::t('app', 'Not ajax found'));
        }
        $key = md5(Url::canonical().Json::encode(Yii::$app->request->post()));

        $currentFashion = (int)Yii::$app->request->post('fashion');
        $currentSize = (int)Yii::$app->request->post('size');
        $currentCount = (int)Yii::$app->request->post('count');
        $currentWatermark = (int)Yii::$app->request->post('watermark');
        $postElement = (int)Yii::$app->request->post('element');


        $model = Item::find()->with([
            'element0',
            'itemWatermarks',
            'itemElements',
            'itemCategories',
            'itemCategories'
        ])->where("id = :id", [':id' => (int)Yii::$app->request->post('item')])->one();
        if (!$model) {
            throw new BadRequestHttpException(Yii::t('app', 'Нет такой товара'));
        }

        $elementItem = Element::find()->where("id = :id AND fashion = :fashion",
            [
                ':id' => $postElement,
                ':fashion' => $currentFashion,
            ])->one();
        if(!$elementItem){
            if($currentFashion == $model->element0->fashion){
                $elementItem = $model->element0;
            }else{
                $elementItem = $model->element0;
//                $elementItem = Element::find()->where("fashion = :fashion",
//                    [
//                        ':fashion' => $currentFashion,
//                    ])->orderBy('fashion asc, name asc')->one();
            }
        }

        if (!$elementItem) {
            throw new BadRequestHttpException(Yii::t('app', 'Нет такой основы'));
        }
        $elementId = ArrayHelper::map($model->itemElements, 'element', 'element');
        $elements = Element::getByItem($elementId, $model, $currentFashion);
        $elementsForFashions = Element::getByItem($elementId);
        $fashions = Fashion::getBuItem($elementsForFashions, $model);
        $sizeId = ArrayHelper::map($model->element0->elementSizes, 'size', 'size');
        $size = Proportion::find()->where(['in', 'id', $sizeId])->orderBy("id asc")->all();

        if ($elementItem->fashion != $currentFashion && isset($elements[0])) {
            $elementItem = $elements[0];
        }
        if($model->element0->fashion == $currentFashion){
            $elements = ArrayHelper::merge([$model->element0], $elements);
        }
//        $elements = ArrayHelper::merge([$elements[0]], $elements);

//        foreach($elements AS $idd => $element){
//            if($element->fashion != $currentFashion){
//                unset($elements[$idd]);
//            }
//        }

        $html = $this->renderPartial('block', [
            'model' => $model,
            'elements' => $elements,
            'fashions' => $fashions,
            'size' => $size,
            'currentFashion' => $currentFashion,
            'currentSize' => $currentSize,
            'currentCount' => $currentCount,
            'currentWatermark' => $currentWatermark,
            'elementItem' => $elementItem,
            'preview' => (int)Yii::$app->request->get('preview'),
        ]);
        echo $html;
    }

    public function actionView($url)
    {
        $model = Item::find()->with(['element0', 'itemWatermarks', 'itemElements', 'itemCategories', 'itemCategories'])->where("url = :url", [':url' => $url])->one();
        if(!$model){
            throw new BadRequestHttpException(Yii::t('app', 'Нет такого товара'));
        }
        $elementItem = $model->element0;
        $elementId = ArrayHelper::map($model->itemElements, 'element', 'element');
        $elements = Element::getByItem($elementId, $model);
        $elementsForFashions = Element::getByItem($elementId);
        $fashions = Fashion::getBuItem($elementsForFashions, $model);
        $sizeId = ArrayHelper::map($elementItem->elementSizes, 'size', 'size');
        $size = Proportion::find()->where(['in', 'id', $sizeId])->orderBy("id asc")->all();
        $key = md5(Url::canonical());
        $timeCache = self::TIME;
        $items = Yii::$app->cache->get($key);
        if($items === false) {
            $items = Item::getElementsForItemPage($model);
            Yii::$app->cache->set($key, $items, $timeCache);
        }
        $currentFashion = $elementItem->fashion;
        $currentSize = 0;
        $currentCount = 1;
        $currentWatermark = 0;
        $elements = ArrayHelper::merge([$model->element0], $elements);
        return $this->render('view', [
            'model' => $model,
            'items' => $items,
            'elements' => $elements,
            'fashions' => $fashions,
            'size' => $size,
            'currentFashion' => $currentFashion,
            'currentSize' => $currentSize,
            'currentCount' => $currentCount,
            'currentWatermark' => $currentWatermark,
            'elementItem' => $elementItem,
            'preview' => (int)Yii::$app->request->get('preview'),
        ]);
    }

    public function actionChanges()
    {
        if(!Yii::$app->request->isAjax){
            throw new BadRequestHttpException(Yii::t('app', 'Not ajax found'));
        }
        Yii::$app->response->format = 'json';
        return Yii::$app->request->post('watermark');

    }
}
