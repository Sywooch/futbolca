<?php
/**
 * powered by php-shaman
 * HomeSocial.php 08.03.2016
 * NewFutbolca
 */
/* @var $model \frontend\models\News */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Settings;

?>
<div class="side-box">
    <div class="side-box-title"><?=Yii::t('app', 'Социальные сети')?></div>
    <div class="side-box-top"></div>
    <div class="side-box-content">
        <div class="item">
            <!--noindex--><?=Settings::getSettings('button_code_kontakt')?><!--/noindex-->
        </div>
        <div class="item">
            <!--noindex--><?=Settings::getSettings('button_code_tweeter')?><!--/noindex-->
        </div>
    </div>
    <div class="side-box-bot"></div>
</div>