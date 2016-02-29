<?php

namespace backend\controllers;

use backend\models\Element;
use backend\models\ItemWatermark;
use backend\models\Podcategory;
use Yii;
use backend\models\Item;
use backend\models\ItemSearch;
use backend\ext\BaseController;
use yii\console\Request;
use yii\console\Response;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends BaseController
{

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionElement()
    {
        Yii::$app->response->format = 'json';
//        return Yii::$app->request->post('data');
//        $data = explode(',', Yii::$app->request->post('data'));
        if(!Yii::$app->request->post('data')){
            throw new NotFoundHttpException(Yii::t('app', 'неверные параметры'));
        }
        $models = Element::getCatForListForItem(Yii::$app->request->post('data'));
        if(!$models){
            return [];
        }
        return $models;
    }

    public function actionPodcat()
    {
        Yii::$app->response->format = 'json';
//        return Yii::$app->request->post('data');
//        $data = explode(',', Yii::$app->request->post('data'));
        if(!Yii::$app->request->post('data')){
            throw new NotFoundHttpException(Yii::t('app', 'неверные параметры'));
        }
        return ArrayHelper::map(Podcategory::find()->where(['in', 'category', Yii::$app->request->post('data')])->all(), 'id', 'name');
    }

    /**
     * Displays a single Item model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderPartial('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Item();
        $model->position = 0;
        $model->price = 0;
        $model->toppx = 0;
        $model->leftpx = 0;
        $model->resizeH = 0;
        $model->resizeW = 0;
        $model->active = 1;
        $model->home = 2;
        $model->getMarkers();
        $model->getСategories();
        $model->getPodcategories();
        $model->getElements();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save();
                $model->setMarkers();
                $model->setСategories();
                $model->setPodcategories();
                $model->setElements();
                $model->image = UploadedFile::getInstances($model, 'image');
                if($model->image){
                    $imageList = $model->upload();
                    if($imageList){
                        foreach($imageList AS $iName){
                            $watermark = new ItemWatermark();
                            $watermark->item = $model->id;
                            $watermark->name = $iName;
                            if($watermark->validate()){
                                $watermark->save();
                            }
                        }
                    }
                }
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->resizeH = 0;
        $model->resizeW = 0;
        $model->getMarkers();
        $model->getСategories();
        $model->getPodcategories();
        $model->getElements();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save();
                $model->deleteMarkers();
                $model->setMarkers();
                $model->deleteСategories();
                $model->setСategories();
                $model->deletePodcategories();
                $model->setPodcategories();
                $model->deleteElements();
                $model->setElements();
                $model->image = UploadedFile::getInstances($model, 'image');
                if($model->image){
                    $imageList = $model->upload();
                    if($imageList){
                        foreach($imageList AS $iName){
                            $watermark = new ItemWatermark();
                            $watermark->item = $model->id;
                            $watermark->name = $iName;
                            if($watermark->validate()){
                                $watermark->save();
                            }
                        }
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
                return $this->refresh();
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteimg($model, $watermark)
    {
        $watermark = ItemWatermark::find()->where("id = :id AND item = :item", [':id' => $model, ':item' => $watermark])->one();
        if(!$watermark){
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $watermark->delOneImg($watermark->name);
        $watermark->delete();
//        return $this->redirect(['index']);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
