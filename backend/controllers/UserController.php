<?php

namespace backend\controllers;

use backend\models\City;
use backend\models\Region;
use backend\models\UserDescription;
use common\UrlHelper;
use Yii;
use backend\models\User;
use backend\models\UserSearch;
use backend\ext\BaseController;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExcel()
    {
        $models = User::find();
        $models->where("email IS NOT NULL");
        $sort = isset(Yii::$app->request->get(1)['sort']) ? Yii::$app->request->get(1)['sort'] : [];
        if($sort){
            $sort = mb_substr($sort, 0, 1, Yii::$app->charset) == '-' ? [ltrim($sort, '-') => 'desc'] : [$sort => 'asc'];
        }
        $data = isset(Yii::$app->request->get(1)['UserSearch']) ? Yii::$app->request->get(1)['UserSearch'] : null;
        foreach($data AS $k => $v){
            $v = trim($v);
            if($v){

                if(is_numeric($v)){
                    $models->andWhere("$k = :$k", [':'.$k => $v]);
                }else{
                    $v = '%'.$v.'%';
                    $models->andWhere("$k LIKE :$k", [':'.$k => $v]);
                }
            }
        }
        if($sort){
            $models->orderBy($sort);
        }
        $models = $models->all();
        if(!$models){
            return Yii::t('app', 'Нет данных');
        }
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Futbolki ".UrlHelper::home(true))
            ->setLastModifiedBy("Futbolki ".UrlHelper::home(true))
            ->setTitle("Office 2007 XLSX Document")
            ->setSubject("Office 2007 XLSX Document")
            ->setDescription("Document for Office 2007 XLSX.")
            ->setKeywords("Document for Office 2007 XLSX.")
            ->setCategory("Futbolki ".UrlHelper::home(true));
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Login')
            ->setCellValue('C1', 'Email')
            ->setCellValue('D1', 'Name')
            ->setCellValue('E1', 'Phone')
            ->setCellValue('F1', 'Address');

        foreach($models AS $k => $model) {
            $index = ($k + 2);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$index, $model->id)
                ->setCellValue('B'.$index, $model->username)
                ->setCellValue('C'.$index, $model->email)
                ->setCellValue('D'.$index, $model->description0->name. ' ' .$model->description0->soname)
                ->setCellValue('E'.$index, $model->description0->phone)
                ->setCellValue('F'.$index, $model->description0->country. ' ' .$model->description0->city. ' ' .$model->description0->adress);
        }
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="users.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $fileNamePatch = Yii::getAlias('@runtime').'/users.xlsx';
        $objWriter->save($fileNamePatch);
        $f = file_get_contents($fileNamePatch);
        @unlink($fileNamePatch);
        echo $f;
    }

    public function actionRole()
    {
        $model = User::find()->where("id = :id", [':id' => (int)Yii::$app->request->post('pk')])->one();
        if(!$model){
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $model->role = Yii::$app->request->post('value');
        if($model->validate()){
            $model->save();
            echo 'OK';
            Yii::$app->end();
        }
        throw new NotFoundHttpException(Yii::t('app', 'Invalid value'));
    }

    public function actionCity()
    {
        Yii::$app->response->format = 'json';
        $name = Yii::$app->request->get('term');
        return City::listDrop($name);
    }

    public function actionRegion()
    {
        Yii::$app->response->format = 'json';
        $name = Yii::$app->request->get('term');
        return Region::listDrop(0, $name);
    }

    public function actionStatus()
    {
        $model = User::find()->where("id = :id", [':id' => (int)Yii::$app->request->post('pk')])->one();
        if(!$model){
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $model->status = (int)Yii::$app->request->post('value');
        $model->save();
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $description = new UserDescription();
        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = time();
            $model->updated_at = time();
            if(!$model->password_hash){
                $model->password_hash = rand(111111, 999999);
            }
            if($model->validate()){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
                $model->save();
                if($description->load(Yii::$app->request->post())){
                    if($description->validate()){
                        $description->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'description' => $description,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $description = $model->description0;
        $oldPass = $model->password_hash;
        if ($model->load(Yii::$app->request->post())) {
            if(!$model->password_hash){
                $model->password_hash = $oldPass;
            }
            $model->updated_at = time();
            if($model->validate()){
                if($model->password_hash != $oldPass){
                    $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
                }
                $model->save();
                if($description->load(Yii::$app->request->post())){
                    if($description->validate()){
                        $description->save();
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
                return $this->refresh();
            }
        }
        return $this->render('update', [
            'model' => $model,
            'description' => $description,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
