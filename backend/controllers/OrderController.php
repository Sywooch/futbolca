<?php

namespace backend\controllers;

use common\UrlHelper;
use Yii;
use backend\models\Order;
use backend\models\OrderSearch;
use backend\ext\BaseController;
use yii\web\NotFoundHttpException;


/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends BaseController
{

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExcel()
    {
        $models = Order::find();
        $models->where("name IS NOT NULL");
        $sort = isset(Yii::$app->request->get(1)['sort']) ? Yii::$app->request->get(1)['sort'] : null;
        if($sort){
            $sort = mb_substr($sort, 0, 1, Yii::$app->charset) == '-' ? [ltrim($sort, '-') => 'desc'] : [$sort => 'asc'];
        }
        $data = isset(Yii::$app->request->get(1)['OrderSearch']) ? Yii::$app->request->get(1)['OrderSearch'] : [];
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
        $newOrder = new Order();
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
            ->setCellValue('B1', $newOrder->getAttributeLabel('data_start'))
            ->setCellValue('C1', $newOrder->getAttributeLabel('data_finish'))
            ->setCellValue('D1', $newOrder->getAttributeLabel('name'))
            ->setCellValue('E1', $newOrder->getAttributeLabel('soname'))
            ->setCellValue('F1', $newOrder->getAttributeLabel('email'))
            ->setCellValue('G1', $newOrder->getAttributeLabel('phone'))
            ->setCellValue('H1', $newOrder->getAttributeLabel('status'))
            ->setCellValue('I1', $newOrder->getAttributeLabel('adress'))
            ->setCellValue('J1', $newOrder->getAttributeLabel('city'))
            ->setCellValue('K1', $newOrder->getAttributeLabel('country'))
            ->setCellValue('L1', $newOrder->getAttributeLabel('agent'))
            ->setCellValue('M1', 'Товары');

        foreach($models AS $k => $model) {
            $index = ($k + 2);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$index, $model->id)
                ->setCellValue('B'.$index, $model->data_start)
                ->setCellValue('C'.$index, $model->data_finish)
                ->setCellValue('D'.$index, $model->name)
                ->setCellValue('E'.$index, $model->soname)
                ->setCellValue('F'.$index, $model->email)
                ->setCellValue('G'.$index, $model->phone)
                ->setCellValue('H'.$index, Order::getStatusName($model->status))
                ->setCellValue('I'.$index, $model->adress)
                ->setCellValue('J'.$index, $model->city)
                ->setCellValue('K'.$index, $model->country)
                ->setCellValue('L'.$index, $model->agent)
                ->setCellValue('M'.$index, join("\n\t ", $model->getListItemsForExcel()));
        }
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="orders.xlsx"');
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
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldStatus = $model->status;
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                if($model->status == 9 && $oldStatus != $model->status){
                    $model->data_finish = date("Y-m-d H:i:s");
                }
                $model->save();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
                return $this->refresh();
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionEdit()
    {
        $model = Order::find()->where("id = :id", [':id' => (int)Yii::$app->request->post('pk')])->one();
        if(!$model){
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $model->{Yii::$app->request->post('name')} = trim(Yii::$app->request->post('value'));
        if(Yii::$app->request->post('name') == 'status' && Yii::$app->request->post('value') == 9){
            $model->data_finish = date("Y-m-d H:i:s");
        }
        $model->save();
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
