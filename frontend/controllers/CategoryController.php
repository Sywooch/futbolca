<?php

namespace frontend\controllers;

use backend\models\Podcategory;
use common\UrlHelper;
use frontend\models\Category;
use frontend\models\Item;
use common\lib\Pagination;
use yii\web\BadRequestHttpException;
use Yii;

class CategoryController extends \yii\web\Controller
{

//    public function actionIndex()
//    {
//        return $this->render('index');
//    }

    public function actionView($url, $page = 0)
    {
        $category = Category::find()->where("url = :url", [':url' => $url])->one();
        if(!$category){
            throw new BadRequestHttpException(Yii::t('app', 'Нет такой категории'));
        }
        $podcats = Podcategory::find()->where("category = :category", [':category' => $category->id])->all();
        $query = Item::find()->with(['element0', 'itemWatermarks'])->where("active = :active AND {{%item_category}}.category = :category", [
            ':active' => 1,
            ':category' => $category->id,
        ])->innerJoin('{{%item_category}}', '{{%item_category}}.item = {{%item}}.id');
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
        if($podcats){
            $podcats = UrlHelper::podcatList($podcats);
        }
        return $this->render('view', [
            'models' => $models,
            'pages' => $pages,
            'category' => $category,
            'podcats' => $podcats
        ]);
    }
}
