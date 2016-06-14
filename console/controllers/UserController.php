<?php
/**
 * powered by php-shaman
 * UserController.php 10.06.2016
 * NewFutbolca
 */

namespace console\controllers;

use console\models\User;
use console\models\MgUser;
use console\models\UserDescription;
use console\models\UserOldid;
use Yii;


class UserController extends \yii\console\Controller // e:\xampp1\php\php.exe yii user/index
{
    public function actionIndex() {
        $models = MgUser::find()->orderBy('u_id asc')->all();
        foreach ($models AS $model) {
            $user = User::find()->where("username = :username OR email = :email",
                [
                    ':username' => $model->u_login,
                    ':email' => $model->u_email,
                ])->one();
            if($user){
                continue;
            }
            $user = new User();
            $user->username = $model->u_login;
            $user->email = $model->u_email;
            $user->role = 'user';
            $user->password_hash = Yii::$app->security->generatePasswordHash($model->u_login.'123456');
            $user->status = 10;
            $user->created_at = $user->updated_at = time();
            if($user->validate()){
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
                echo $user->id . ' - ' . $user->username . PHP_EOL;
            }

        }
        return 0;
    }
}