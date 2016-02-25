<?php

namespace backend\controllers;

use Yii;
use backend\models\Individual;
use backend\models\IndividualSearch;
use backend\ext\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * IndividualController implements the CRUD actions for Individual model.
 */
class IndividualController extends BaseController
{

    /**
     * Lists all Individual models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IndividualSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Individual model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderPartial('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionStatus()
    {
        $model = Individual::find()->where("id = :id", [':id' => (int)Yii::$app->request->post('pk')])->one();
        if(!$model){
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        if(!Individual::getStatusName(Yii::$app->request->post('value'))){
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $model->status = (int)Yii::$app->request->post('value');
        $model->save();
    }

    /**
     * Creates a new Individual model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Individual();

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save();
                $model->image = UploadedFile::getInstances($model, 'image');
                if($model->image){
                    $imageList = $model->upload();
                    if($imageList){
                        foreach($imageList AS $idName => $iName){
                            $model->{'img'.($idName + 1)} = $iName;
                        }
                        $model->image = null;
                        $model->save();
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
     * Updates an existing Individual model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
                return $this->refresh();
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Individual model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delAllImg();
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Individual model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Individual the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Individual::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
