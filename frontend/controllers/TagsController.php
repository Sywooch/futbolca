<?php

namespace frontend\controllers;

use backend\models\Marker;
use backend\models\Podcategory;
use common\UrlHelper;
use frontend\models\Category;
use frontend\models\Item;
use common\lib\Pagination;
use yii\web\BadRequestHttpException;
use Yii;

class TagsController extends \yii\web\Controller
{

//    public function actionIndex()
//    {
//        return $this->render('index');
//    }

    public function actionView($url, $page = 0)
    {
        $podcat = Marker::find()->where("url = :url", [':url' => $url])->one();
        if(!$podcat){
            throw new BadRequestHttpException(Yii::t('app', 'Нет такой метки'));
        }
        $query = Item::find()->with(['element0', 'itemWatermarks'])->where("active = :active AND {{%item_marker}}.marker = :marker", [
            ':active' => 1,
            ':marker' => $podcat->id,
        ])->innerJoin('{{%item_marker}}', '{{%item_marker}}.item = {{%item}}.id');
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
