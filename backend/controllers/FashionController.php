<?php

namespace backend\controllers;

use common\UrlHelper;
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

    public function actionImport()
    {
        if(isset($_FILES['excel']['tmp_name'])){
            $fl = Yii::getAlias('@backend/runtime/').$_FILES['excel']['name'];
            copy($_FILES['excel']['tmp_name'], $fl);
            $inputFileType = \PHPExcel_IOFactory::identify($fl);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($fl);
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 1; $row <= $highestRow; $row++) {
                $data = [];
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                $data['id'] = (int)$rowData[0][0];
                $data['name'] = $rowData[0][1];
                $data['price'] = (int)$rowData[0][2];
                $model = Fashion::findOne($data['id']);
                if($model){
                    $model->price = $data['price'];
                    $model->save();
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно обновленно!'));
                return $this->refresh();
            }
            @unlink($fl);
        }
        return $this->render('import', [

        ]);
    }

    public function actionExcel()
    {
        $models = Fashion::find();
        $newOrder = new Fashion();
        $models->where("name IS NOT NULL");
        $sort = isset(Yii::$app->request->get(1)['sort']) ? Yii::$app->request->get(1)['sort'] : null;
        if($sort){
            $sort = mb_substr($sort, 0, 1, Yii::$app->charset) == '-' ? [ltrim($sort, '-') => 'desc'] : [$sort => 'asc'];
        }
        $data = isset(Yii::$app->request->get(1)['FashionSearch']) ? Yii::$app->request->get(1)['FashionSearch'] : [];
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
            ->setCellValue('A1', $newOrder->getAttributeLabel('id'))
            ->setCellValue('B1', $newOrder->getAttributeLabel('name'))
            ->setCellValue('C1', $newOrder->getAttributeLabel('price'));

        foreach($models AS $k => $model) {
            $index = ($k + 2);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$index, $model->id)
                ->setCellValue('B'.$index, $model->name)
                ->setCellValue('C'.$index, $model->price);
        }
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="fashions.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
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
        $model->price = 0;
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
