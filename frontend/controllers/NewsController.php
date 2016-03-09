<?php

namespace frontend\controllers;

use frontend\models\News;
use yii\web\BadRequestHttpException;
use Yii;

class NewsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models = News::find()->orderBy('id desc')->all();

        return $this->render('index', [
            'models' => $models,
        ]);
    }

    public function actionView($url)
    {
        $model = News::find()->where("url = :url", [':url' => $url])->one();
        if(!$model){
            throw new BadRequestHttpException(Yii::t('app', 'Нет такой записи в блоге'));
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
