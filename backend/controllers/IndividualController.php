<?php

namespace backend\controllers;

use common\UrlHelper;
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

    public function actionExcel()
    {
        $models = Individual::find();
        $models->where("name IS NOT NULL");
        $sort = isset(Yii::$app->request->get(1)['sort']) ? Yii::$app->request->get(1)['sort'] : null;
        if($sort){
            $sort = mb_substr($sort, 0, 1, Yii::$app->charset) == '-' ? [ltrim($sort, '-') => 'desc'] : [$sort => 'asc'];
        }
        $data = isset(Yii::$app->request->get(1)['IndividualSearch']) ? Yii::$app->request->get(1)['IndividualSearch'] : [];
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
            ->setCellValue('B1', 'Имя')
            ->setCellValue('C1', 'Статус')
            ->setCellValue('D1', 'Телефон')
            ->setCellValue('E1', 'Email')
            ->setCellValue('F1', 'Image 1')
            ->setCellValue('G1', 'Image 2')
            ->setCellValue('H1', 'Image 3')
            ->setCellValue('I1', 'Image 4')
            ->setCellValue('J1', 'Комментарий')
            ->setCellValue('K1', 'Комментарий админа')
            ->setCellValue('L1', 'Создан');

        foreach($models AS $k => $model) {
            $index = ($k + 2);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$index, $model->id)
                ->setCellValue('B'.$index, $model->name)
                ->setCellValue('C'.$index, Individual::getStatusName($model->status))
                ->setCellValue('D'.$index, $model->phone)
                ->setCellValue('E'.$index, $model->email)
                ->setCellValue('F'.$index, $model->getImageLink(1))
                ->setCellValue('G'.$index, $model->getImageLink(2))
                ->setCellValue('H'.$index, $model->getImageLink(3))
                ->setCellValue('I'.$index, $model->getImageLink(4))
                ->setCellValue('J'.$index, $model->comment)
                ->setCellValue('K'.$index, $model->admintext)
                ->setCellValue('L'.$index, $model->created);
        }
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="individual_order.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
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
