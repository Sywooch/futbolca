<?php
/**
 * powered by php-shaman
 * TestController.php 24.02.2016
 * NewFutbolca
 */

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use backend\ext\BaseController;

class TestController extends BaseController
{
    public function actionIndex()
    {
        var_dump('OK');
    }
}