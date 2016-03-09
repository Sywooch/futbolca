<?php

namespace frontend\controllers;

use backend\models\Podcategory;
use common\UrlHelper;
use frontend\models\Category;
use frontend\models\Item;
use common\lib\Pagination;
use yii\web\BadRequestHttpException;
use Yii;

class PodcatController extends \yii\web\Controller
{

//    public function actionIndex()
//    {
//        return $this->render('index');
//    }

    public function actionView($url, $page = 0)
    {
        $podcat = Podcategory::find()->with(['category0'])->where("url = :url", [':url' => $url])->one();
        if(!$podcat){
            throw new BadRequestHttpException(Yii::t('app', 'Нет такой подкатегории'));
        }
        $query = Item::find()->with(['element0', 'itemWatermarks'])->where("active = :active AND {{%item_podcategory}}.podcategory = :podcategory", [
            ':active' => 1,
            ':podcategory' => $podcat->id,
        ])->innerJoin('{{%item_podcategory}}', '{{%item_podcategory}}.item = {{%item}}.id');
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => $countQuery->count(),
        ]);

        $models = $query->orderBy('{{%item}}.position desc, {{%item}}.id desc')
            ->distinct()
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('view', [
            'models' => $models,
            'pages' => $pages,
            'podcat' => $podcat
        ]);
    }
}
