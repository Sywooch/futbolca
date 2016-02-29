<?php

namespace backend\controllers;

use backend\models\ElementSize;
use backend\models\Fashion;
use Yii;
use backend\models\Element;
use backend\models\ElementSearch;
use backend\ext\BaseController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ElementController implements the CRUD actions for Element model.
 */
class ElementController extends BaseController
{

    /**
     * Lists all Element models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ElementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Element model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Element model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Element();
        $fashion = new Fashion();
        $fashion->price = 0;
        $fashion->name = '-';
        $model->home = 2;
        $model->stock = 1;
        $model->toppx = 150;
        $model->leftpx = 140;
        $model->price = 0;
        $model->increase = 0;
        $model->resizeW = 0;
        $model->resizeH = 0;
        if ($model->load(Yii::$app->request->post())) {
            if ($fashion->load(Yii::$app->request->post())) {
                if(!$fashion->price){
                    $fashion->price = 0;
                }
                if($fashion->name != '-') {
                    if ($fashion->validate()) {
                        $fashion->save();
                        $model->fashion = $fashion->id;
                    }
                }
            }
            if($model->validate()){
                $sizes = $model->size;
                $model->size = null;
                $model->save();
                ElementSize::deleteAll("element = :element", [':element' => $model->id]);
                if(is_array($sizes) && sizeof($sizes) > 0){
                    foreach($sizes AS $size){
                        $elementSize = new ElementSize();
                        $elementSize->element = $model->id;
                        $elementSize->size = (int)$size;
                        $elementSize->save();
                    }
                }
                $model->image = UploadedFile::getInstance($model, 'image');
                if($model->image){
                    $model->photo = $model->upload();
                    $model->image = null;
                    $model->save();
                }
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'fashion' => $fashion,
        ]);
    }

    /**
     * Updates an existing Element model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $fashion = new Fashion();
        $fashion->price = 0;
        $fashion->name = '-';
        $oldSizes = ArrayHelper::map($model->sizes, 'size', 'size');
        $model->size = $oldSizes;
        $model->resizeW = 0;
        $model->resizeH = 0;
        if ($model->load(Yii::$app->request->post())) {
            if ($fashion->load(Yii::$app->request->post())) {
                if(!$fashion->price){
                    $fashion->price = 0;
                }
                if($fashion->name != '-'){
                    if($fashion->validate()){
                        $fashion->save();
                        $model->fashion = $fashion->id;
                    }
                }
            }
            if($model->validate()){
                $sizes = $model->size;
                $model->size = null;
                $model->save();
                if(is_array($sizes) && sizeof($sizes) > 0 && array_diff($sizes, $oldSizes)){
                    ElementSize::deleteAll("element = :element", [':element' => $model->id]);
                    foreach($sizes AS $size){
                        $elementSize = new ElementSize();
                        $elementSize->element = $model->id;
                        $elementSize->size = (int)$size;
                        $elementSize->save();
                    }
                }
                $model->image = UploadedFile::getInstance($model, 'image');
                if($model->image){
                    $model->photo = $model->upload();
                    $model->image = null;
                    $model->save();
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
                return $this->refresh();
            }
        }
        return $this->render('update', [
            'model' => $model,
            'fashion' => $fashion,
        ]);
    }

    public function actionEdit()
    {
        $model = Element::find()->where("id = :id", [':id' => (int)Yii::$app->request->post('pk')])->one();
        if(!$model){
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $model->{Yii::$app->request->post('name')} = Yii::$app->request->post('value');
        if($model->validate()){
            $model->save();
            echo 'OK';
            Yii::$app->end();
        }
        throw new NotFoundHttpException(Yii::t('app', 'Invalid value'));
    }

    /**
     * Deletes an existing Element model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteImage(true);
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionDeleteimg($id)
    {
        $model = $this->findModel($id);
        $model->deleteImage();
        $model->photo = null;
        $model->save();
//        return $this->redirect(['index']);
    }

    /**
     * Finds the Element model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Element the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Element::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
