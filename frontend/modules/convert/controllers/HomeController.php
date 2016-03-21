<?php

namespace app\modules\convert\controllers;

set_time_limit(0);

use frontend\models\id\UserOldid;
use yii\web\Controller;
use Yii;
use frontend\models\mg\User;
use frontend\models\UserDescription;

class HomeController extends Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->post('ok')) {
            ob_start();
            echo 'Start ======= <br>'.PHP_EOL;
            ob_flush();
            flush();
            $models = User::find()->orderBy('u_id asc')->all();
            foreach ($models AS $model) {
                $user = \frontend\models\User::find()->where("username = :username",
                    [':username' => $model->u_login])->one();
                if (!$user) {
                    $user = new \backend\models\User();
                    $user->username = $model->u_login;
                    $user->role = 'user';
                    $user->password_hash = Yii::$app->security->generatePasswordHash($model->u_login . '123456');
                    $user->email = $model->u_email;
                    $user->status = 10;
                    $user->created_at = time();
                    $user->updated_at = time();
                    if ($user->validate()) {
                        $user->save(false);
                        $oldId = UserOldid::find()->where("id = :id AND old = :old", [':id' => $user->id, ':old' => $model->u_id])->one();
                        if(!$oldId){
                            $oldId = new UserOldid();
                            $oldId->id = $user->id;
                            $oldId->old = $model->u_id;
                            $oldId->save();
                        }
                        $userDescription = new UserDescription();
                        $userDescription->user = $user->id;
                        $userDescription->name = $model->u_name;
                        $userDescription->soname = $model->u_soname;
                        $userDescription->adress = $model->u_adress;
                        $userDescription->code = $model->u_index;
                        $userDescription->city = $model->u_city;
                        $userDescription->region = $model->u_region;
                        $userDescription->country = $model->u_country;
                        $userDescription->phone = $model->u_phone;
                        $userDescription->fax = $model->u_fax;
                        $userDescription->icq = $model->u_icq;
                        $userDescription->skape = $model->u_skape;
                        $userDescription->agent = $model->u_agent;
                        $userDescription->ip = $model->u_ip;
                        if ($userDescription->validate()) {
                            $userDescription->save(false);
                        }
                        echo $user->id . ' - ' . $user->username .' <br>'.PHP_EOL;
                        ob_flush();
                        flush();
                    }
                }
            }
            echo 'Stop =========== <br>'.PHP_EOL;
            ob_flush();
            flush();
            ob_clean();
        }
        return $this->render('index');
    }
}
