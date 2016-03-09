<?php

namespace frontend\controllers;

use frontend\models\Individual;
use Yii;
use yii\web\UploadedFile;

class IndividualController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new Individual();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save(false);
                $model->image = UploadedFile::getInstances($model, 'image');
                if($model->image){
                    $imageList = $model->upload();
                    if($imageList){
                        foreach($imageList AS $idName => $iName){
                            $model->{'img'.($idName + 1)} = $iName;
                        }
                        $model->image = null;
                        $model->save(false);
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Запрос отправлен администратору!'));
                return $this->refresh();
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
