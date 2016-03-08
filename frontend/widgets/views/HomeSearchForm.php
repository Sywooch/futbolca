<?php
/**
 * powered by php-shaman
 * HomeSearchForm.php 08.03.2016
 * NewFutbolca
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="side-box">
    <div class="side-box-title"><?=Yii::t('app', 'Поиск по сайту')?></div>
</div>
<?php $form = ActiveForm::begin([
    'id' => 'search-form',
    'method' => 'get',
    'action' => Url::toRoute('search/index'),
    'options' => ['accept-charset' => Yii::$app->charset]
]); ?>
    <input id="seach_text_id" type="text" name="seach_text" value="<?=Yii::$app->request->get('seach_text')?>" class="search_form_text" autocomplete="off" placeholder="<?=Yii::t('app', 'Введите слово для поиска')?>">
    <br><br><input type="submit" value="<?=Yii::t('app', 'Искать')?>" class="search_form_submit">
<?php ActiveForm::end(); ?>
