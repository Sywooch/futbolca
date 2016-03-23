<?php

namespace backend\controllers;

use backend\models\ElementSize;
use backend\models\Fashion;
use common\UrlHelper;
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
                $data['fashion'] = $rowData[0][1];
                $data['name'] = $rowData[0][2];
                $data['price'] = (int)$rowData[0][3];
                $data['increase'] = $rowData[0][4];
                $data['stock'] = (int)$rowData[0][5];
                $data['photo'] = $rowData[0][6];

                $model = Element::findOne($data['id']);
                if($model){
                    $model->price = $data['price'];
                    $model->increase = $data['price'];
                    $model->stock = $data['stock'];
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
        $models = Element::find();
        $newOrder = new Element();
        $models->where("name IS NOT NULL");
        $sort = isset(Yii::$app->request->get(1)['sort']) ? Yii::$app->request->get(1)['sort'] : null;
        if($sort){
            $sort = mb_substr($sort, 0, 1, Yii::$app->charset) == '-' ? [ltrim($sort, '-') => 'desc'] : [$sort => 'asc'];
        }
        $data = isset(Yii::$app->request->get(1)['ElementSearch']) ? Yii::$app->request->get(1)['ElementSearch'] : [];
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
            ->setCellValue('B1', $newOrder->getAttributeLabel('fashion'))
            ->setCellValue('C1', $newOrder->getAttributeLabel('name'))
            ->setCellValue('D1', $newOrder->getAttributeLabel('price'))
            ->setCellValue('E1', $newOrder->getAttributeLabel('increase'))
            ->setCellValue('F1', $newOrder->getAttributeLabel('stock'))
            ->setCellValue('G1', $newOrder->getAttributeLabel('photo'));

        foreach($models AS $k => $model) {
            $index = ($k + 2);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$index, $model->id)
                ->setCellValue('B'.$index, $model->fashion0->name)
                ->setCellValue('C'.$index, $model->name)
                ->setCellValue('D'.$index, $model->price)
                ->setCellValue('E'.$index, $model->increase)
                ->setCellValue('F'.$index, $model->stock)
                ->setCellValue('G'.$index, $model->getImageLink());
        }
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="osnovi.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $fileNamePatch = Yii::getAlias('@runtime').'/osnovi.xlsx';
        $objWriter->save($fileNamePatch);
        $f = file_get_contents($fileNamePatch);
        @unlink($fileNamePatch);
        echo $f;
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
