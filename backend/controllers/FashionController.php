<?php

namespace backend\controllers;

use Yii;
use backend\models\Fashion;
use backend\models\FashionSearch;
use backend\ext\BaseController;
use yii\web\NotFoundHttpException;

/**
 * FashionController implements the CRUD actions for Fashion model.
 */
class FashionController extends BaseController
{

    /**
     * Lists all Fashion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FashionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEditf()
    {
        $model = Fashion::find()->where("id = :id", [':id' => (int)Yii::$app->request->post('pk')])->one();
        if(!$model){
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $model->{Yii::$app->request->post('name')} = trim(Yii::$app->request->post('value'));
        if($model->validate()){
            $model->save();
            echo 'OK';
            Yii::$app->end();
        }
        throw new NotFoundHttpException(Yii::t('app', 'Invalid params'));
    }

    /**
     * Displays a single Fashion model.
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
     * Creates a new Fashion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Fashion();

        if ($model->load(Yii::$app->request->post())) {
            if(!$model->price){
                $model->price = 0;
            }
            if($model->validate()){
                $model->save();
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Fashion model.
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
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Fashion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Fashion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Fashion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fashion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
