<?php

namespace backend\controllers;

use Yii;
use backend\models\Paying;
use backend\models\PayingSearch;
use backend\ext\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * PayingController implements the CRUD actions for Paying model.
 */
class PayingController extends BaseController
{

    /**
     * Lists all Paying models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Paying model.
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
     * Creates a new Paying model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Paying();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->image = UploadedFile::getInstance($model, 'image');
                if($model->image){
                    $model->img = $model->upload();
                }
                $model->image = null;
                $model->save();
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Paying model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->image = UploadedFile::getInstance($model, 'image');
                if($model->image){
                    $model->img = $model->upload();
                }
                $model->image = null;
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
     * Deletes an existing Paying model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteImage();
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionDeleteimg($id)
    {
        $model = $this->findModel($id);
        $model->deleteImage();
        $model->img = null;
        $model->save();
//        return $this->redirect(['index']);
    }

    /**
     * Finds the Paying model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Paying the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paying::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
