<?php

namespace backend\controllers;

use backend\models\Element;
use backend\models\ItemWatermark;
use backend\models\Podcategory;
use common\UrlHelper;
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
                $data['position'] = $rowData[0][2];
                $data['url'] = (int)$rowData[0][3];
                $data['code'] = $rowData[0][4];
                $data['price'] = (int)$rowData[0][5];
                $data['active'] = $rowData[0][6];

                $model = Item::findOne($data['id']);
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
        $models = Item::find();
        $newOrder = new Item();
        $models->where("name IS NOT NULL");
        $sort = isset(Yii::$app->request->get(1)['sort']) ? Yii::$app->request->get(1)['sort'] : null;
        if($sort){
            $sort = mb_substr($sort, 0, 1, Yii::$app->charset) == '-' ? [ltrim($sort, '-') => 'desc'] : [$sort => 'asc'];
        }
        $data = isset(Yii::$app->request->get(1)['ItemSearch']) ? Yii::$app->request->get(1)['ItemSearch'] : [];
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
            ->setCellValue('C1', $newOrder->getAttributeLabel('position'))
            ->setCellValue('D1', $newOrder->getAttributeLabel('url'))
            ->setCellValue('E1', $newOrder->getAttributeLabel('code'))
            ->setCellValue('F1', $newOrder->getAttributeLabel('price'))
            ->setCellValue('G1', $newOrder->getAttributeLabel('active'));

        foreach($models AS $k => $model) {
            $index = ($k + 2);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$index, $model->id)
                ->setCellValue('B'.$index, $model->name)
                ->setCellValue('C'.$index, $model->position)
                ->setCellValue('D'.$index, $model->url)
                ->setCellValue('E'.$index, $model->code)
                ->setCellValue('F'.$index, $model->price)
                ->setCellValue('G'.$index, Item::listHomeName($model->active));
        }
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="prodacts.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $fileNamePatch = Yii::getAlias('@runtime').'/prodacts.xlsx';
        $objWriter->save($fileNamePatch);
        $f = file_get_contents($fileNamePatch);
        @unlink($fileNamePatch);
        echo $f;
    }

    public function actionElement()
    {
        Yii::$app->response->format = 'json';
        $data = Yii::$app->request->post('data');
        if(!is_array($data)){
            $data = [];
        }
        if(!is_array($data)){
            throw new NotFoundHttpException(Yii::t('app', 'Неверные параметры'));
        }
        $models = Element::getCatForListForItem($data);
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionEdit()
    {
        $model = Item::find()->where("id = :id", [':id' => (int)Yii::$app->request->post('pk')])->one();
        if(!$model){
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $model->{Yii::$app->request->post('name')} = trim(Yii::$app->request->post('value'));
        $model->save();
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
        $model->getFashion();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save(false);
                $model->setMarkers();
                $model->setСategories();
                $model->setPodcategories();
                $model->setElements();
                $model->image = UploadedFile::getInstances($model, 'image');
                if($model->image){
                    $imageList = $model->upload();
                    if($imageList){
                        foreach($imageList AS $keyI => $iName){
                            $watermark = new ItemWatermark();
                            $watermark->item = $model->id;
                            $watermark->name = $iName;
                            $watermark->position = (5 - $keyI);
                            if($watermark->validate()){
                                $watermark->save(false);
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
        $model->getFashion();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save(false);
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
                        foreach($imageList AS $keyI => $iName){
                            $watermark = new ItemWatermark();
                            $watermark->item = $model->id;
                            $watermark->name = $iName;
                            $watermark->position = (5 - $keyI);
                            if($watermark->validate()){
                                $watermark->save(false);
                            }
                        }
                    }
                }
                if($model->imagePosition){
                    foreach($model->imagePosition AS $idPos => $imagePosition){
                        $watermark = ItemWatermark::findOne((int)$idPos);
                        if($watermark){
                            $watermark->position = (int)$imagePosition;
                            $watermark->save();
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
