<?php

namespace frontend\controllers;

use common\CImageHandler;
use frontend\models\Element;
use frontend\models\ItemWatermark;
use yii\web\BadRequestHttpException;
use Yii;

class ImageController extends \yii\web\Controller
{

    const TIME = 86400;

    public function actionCreate($type, $element = null, $water = null, $top = 0, $left = 0)
    {
        $key = md5($type.$element.$water.$top.$left);
        $timeCache = self::TIME;
        $data = Yii::$app->cache->get($key);
        if($data === false){
            $element .= '.%';
            $element = Element::find()->where("photo LIKE :photo", [':photo' => $element])->one();
            if (!$element) {
                throw new BadRequestHttpException(Yii::t('app', 'Не найдена основа'));
            }
            $water .= '%';
            $water = ItemWatermark::find()->where("name LIKE :name", [':name' => $water])->one();
            if (!$water) {
                throw new BadRequestHttpException(Yii::t('app', 'Не найдена вотемарка'));
            }

            $dirElement = Yii::getAlias('@frontend/web/images/element/' . $element->id . '/' . ($type == 'mini' ? 'mini_' : '') . $element->photo);
            $dirWater = Yii::getAlias('@frontend/web/images/item/' . $water->item . '/' . ($type == 'mini' ? 'mini_' : '') . $water->name);
            $dirTemp = Yii::getAlias('@frontend/web/images/tepm/' . $key . '.jpg');
            $ih = new CImageHandler();
            $ih->load($dirElement);
            if ($type == 'mini') {
                $ih->watermark($dirWater, round($left * 0.57), round($top * 0.67), CImageHandler::CORNER_LEFT_TOP);
                $ih->thumb(120, 120);
            } else {
                $ih->watermark($dirWater, $left, $top, CImageHandler::CORNER_LEFT_TOP);
            }
            $ih->save($dirTemp, CImageHandler::IMG_JPEG, 100);
            $data = file_get_contents($dirTemp);
            Yii::$app->cache->set($key, $data, $timeCache);
            @unlink($dirTemp);
        }
        header('Content-type: image/jpeg');
        echo $data;
//        var_dump($dirWater);
    }

    public function actionPreview($type, $element = null, $water = null, $top = 0, $left = 0)
    {
        $key = md5($type.$element.$water.$top.$left);
        $element .= '.%';
        $element = Element::find()->where("photo LIKE :photo", [':photo' => $element])->one();
        if (!$element) {
            throw new BadRequestHttpException(Yii::t('app', 'Не найдена основа'));
        }
        $water .= '%';
        $water = ItemWatermark::find()->where("name LIKE :name", [':name' => $water])->one();
        if (!$water) {
            throw new BadRequestHttpException(Yii::t('app', 'Не найдена вотемарка'));
        }

        $dirElement = Yii::getAlias('@frontend/web/images/element/' . $element->id . '/' . ($type == 'mini' ? 'mini_' : '') . $element->photo);
        $dirWater = Yii::getAlias('@frontend/web/images/item/' . $water->item . '/' . ($type == 'mini' ? 'mini_' : '') . $water->name);
        $dirTemp = Yii::getAlias('@frontend/web/images/tepm/' . $key . '.jpg');
        $ih = new CImageHandler();
        $ih->load($dirElement);
        if ($type == 'mini') {
            $ih->watermark($dirWater, round($left * 0.57), round($top * 0.67), CImageHandler::CORNER_LEFT_TOP);
            $ih->thumb(120, 120);
        } else {
            $ih->watermark($dirWater, $left, $top, CImageHandler::CORNER_LEFT_TOP);
        }
        $ih->save($dirTemp, CImageHandler::IMG_JPEG, 100);
        $data = file_get_contents($dirTemp);
        @unlink($dirTemp);
        header('Content-type: image/jpeg');
        echo $data;
//        var_dump($dirWater);
    }
}
