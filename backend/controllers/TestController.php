<?php
/**
 * powered by php-shaman
 * TestController.php 24.02.2016
 * NewFutbolca
 */

namespace backend\controllers;

use Yii;
use backend\ext\BaseController;

class TestController extends BaseController
{
    public function actionIndex()
    {
        var_dump('OK');
    }
}