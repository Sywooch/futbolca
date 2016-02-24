<?php

namespace frontend\controllers;

use app\models\Author;
use Yii;
use app\models\Book;
use app\models\BookSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        if($action->id == 'index'){
            Url::remember();
        }

        return $result;
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
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
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();
        $author = new Author();
        if ($model->load(Yii::$app->request->post())) {
            if(isset($_POST['Author']['name']) && $_POST['Author']['name'] && $author->load(Yii::$app->request->post())){
                if($author->validate()) {
                    $author->save();
                    $model->author = $author->id;
                }
            }
            if($model->validate()){
                $model->save();
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if($model->imageFile){
                    $model->preview = $model->uploadPreview();
                    $model->save();
                }
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'author' => $author,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $author = new Author();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if(isset($_POST['Author']['name']) && $_POST['Author']['name'] && $author->load(Yii::$app->request->post())){
                if($author->validate()) {
                    $author->save();
                    $model->author = $author->id;
                }
            }
            if($model->validate()){
                $model->save();
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if($model->imageFile){
                    $model->preview = $model->uploadPreview();
                    $model->save();
                }
                return $this->redirect(Url::previous());
            }
        }
        return $this->render('update', [
            'model' => $model,
            'author' => $author,
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Book::deleteImage($model->preview);
        $model->delete();
        return $this->redirect(Url::previous());
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
