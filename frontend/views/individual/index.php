<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Individual */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Индивидуальный заказ');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заказы'), 'url' => ['user/orders']];
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $this->title
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title
]);

$this->registerJsFile('/js/jquery.maskedinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$js = <<<JS
    jQuery(function($){
        $("#individual-phone").mask("+38(099)999-99-99");
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-phone-ms');
?>

<h1 class="page-title"><?=Yii::t('app', 'Индивидуальный заказ')?></h1>
<p style="color: green; font-size: 16px; text-align: center;"><?=Yii::$app->session->getFlash('success')?></p>
<div style="text-align: justify">
    <?php $form = ActiveForm::begin([
        'id' => 'individual-form',
        'options' => [
            'enctype' => 'multipart/form-data',
            'accept-charset' => Yii::$app->charset,
        ]
    ]); ?>
    <table width="100%" border="0" cellspacing="5" cellpadding="2">
        <tr>
            <td style="vertical-align: middle;">
                Фото&nbsp;(изображение)<br />
                <small class="small-text">(GIF, JPG, JPEG, PNG)</small>
            </td>
            <td>
                <ol>
                    <?php for($i = 0; $i < 4; $i++){ ?>
                        <li><?= $form->field($model, 'image[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'size' => 38])->label('') ?></li>
                    <?php } ?>
                </ol>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: middle;">Имя</td>
            <td><?= $form->field($model, 'name')->textInput(['maxlength' => true, 'size' => 50, 'class' => ''])->label('') ?></td>
        </tr>
        <tr>
            <td style="vertical-align: middle;">Телефон</td>
            <td><?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'size' => 50, 'class' => ''])->label('') ?></td>
        </tr>
        <tr>
            <td style="vertical-align: middle;">E-mail</td>
            <td><?= $form->field($model, 'email')->textInput(['maxlength' => true, 'size' => 50, 'class' => ''])->label('') ?></td>
        </tr>
        <tr>
            <td style="vertical-align: middle;">Комментарии</td>
            <td><?= $form->field($model, 'comment')->textarea(['cols' => 50, 'row' => 8, 'class' => '', 'style' => 'min-height: 80px;'])->label('') ?></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <?= $form->field($model, 'verifyCode')->widget(
                    \common\recaptcha\ReCaptcha::className(),
                    ['siteKey' => \common\recaptcha\ReCaptcha::SITE_KEY]
                )->label('') ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="vertical-align: middle; text-align: center;">
                <input type="submit" value="Заказать" style="width: 120px;" />
            </td>
        </tr>
    </table>
    <?php ActiveForm::end(); ?>
</div>

