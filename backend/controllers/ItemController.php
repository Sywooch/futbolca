<?php

namespace backend\controllers;

use backend\models\ItemWatermark;
use Yii;
use backend\models\Item;
use backend\models\ItemSearch;
use backend\ext\BaseController;
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
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save();
                $model->setMarkers();
                $model->setСategories();
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
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save();
                $model->deleteMarkers();
                $model->setMarkers();
                $model->deleteСategories();
                $model->setСategories();
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
