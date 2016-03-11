<?php

namespace frontend\controllers;

use frontend\models\Item;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use common\lib\Pagination;

class SearchController extends \yii\web\Controller
{
    public function actionAutocomplete()
    {
        if(!Yii::$app->request->isAjax){
            throw new BadRequestHttpException(Yii::t('app', 'Not ajax found'));
        }
        $search = Yii::$app->request->post('term');
        if(!$search){
            throw new BadRequestHttpException(Yii::t('app', 'Not search text'));
        }
        $search = $search.'%';
        Yii::$app->response->format = 'json';
        return ArrayHelper::map(Item::find()->where("name LIKE :name AND active = 1", [':name' => $search])->orderBy('name asc')->all(), 'name', 'name');
    }

    public function actionIndex($seach_text = null)
    {
        $search = trim(Yii::$app->request->get('seach_text'));
        $models = [];
        $pages = null;
        if($search){
            $searchText = $search.'%';
            $query = Item::find()->with(['element0', 'itemWatermarks'])->where("active = :active AND name LIKE :name", [
                ':active' => 1,
                ':name' => $searchText,
            ]);
            $countQuery = clone $query;
            $pages = new Pagination([
                'totalCount' => $countQuery->count(),
                'defaultPageSize' => $countQuery->count(),
            ]);
            $models = $query->orderBy('{{%item}}.name asc, {{%item}}.position desc')
                ->distinct()
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        }

        return $this->render('index', [
            'search' => $search,
            'models' => $models,
            'pages'=> $pages
        ]);
    }
}
