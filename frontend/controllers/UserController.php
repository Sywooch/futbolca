<?php

namespace frontend\controllers;

use frontend\models\Order;
use frontend\models\OrderSearch;
use frontend\models\User;
use frontend\models\UserDescription;
use yii\filters\AccessControl;
use Yii;
use yii\web\BadRequestHttpException;

class UserController extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
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
        ];
    }

    public function actionView($id = 0)
    {
        $model = Order::find()->where("id = :id AND user = :user", [':id' => $id, ':user' => Yii::$app->user->id])->one();
        if(!$model){
            throw new BadRequestHttpException(Yii::t('app', 'Not ajax found'));
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionOrders($page = 0)
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('orders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSettings()
    {
        $user = User::find()->where("id = :id", [':id' => Yii::$app->user->id])->one();
        if($user->load(Yii::$app->request->post())){
            if(Yii::$app->security->validatePassword($user->currentPassword, $user->password_hash)){
                if($user->validate()){
                    $user->password = trim($user->password);
                    if($user->password){
                        $user->password_hash = Yii::$app->security->generatePasswordHash($user->password);
                    }
                    $user->save(false);
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохранено'));
                    return $this->refresh();
                }
            }else{
                Yii::$app->session->setFlash('error', Yii::t('app', 'Неверный текущий пароль'));
            }
        }
        return $this->render('settings', [
            'user' => $user
        ]);
    }

    public function actionInformation()
    {
        $description = UserDescription::find()->where("user = :user", [':user' => Yii::$app->user->id])->one();
        if($description->load(Yii::$app->request->post())){
            $description->save();
            Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохранено'));
            return $this->refresh();

        }
        return $this->render('information', [
            'description' => $description
        ]);
    }

}
