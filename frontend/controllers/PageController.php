<?php

namespace frontend\controllers;

use frontend\models\Page;
use yii\web\BadRequestHttpException;
use Yii;

class PageController extends \yii\web\Controller
{
//    public function actionIndex()
//    {
//        return $this->render('index');
//    }

    public function actionView($url)
    {
        $model = Page::find()->where("url = :url", [':url' => $url])->one();
        if(!$model){
            throw new BadRequestHttpException(Yii::t('app', 'Нет такой категории'));
        }
        return $this->render('view', [
            'model' => $model
        ]);
    }
}
