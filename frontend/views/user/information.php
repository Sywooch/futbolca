<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $description \frontend\models\UserDescription */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Данные для заказа');
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
        $("#userdescription-phone").mask("+38(099)999-99-99");
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-phone-ms');
?>

<h1 class="page-title"><?=Yii::t('app', 'Данные для заказа')?></h1>
<p style="text-align: center; color:green;"><?= Yii::$app->session->getFlash('success')?></p>
<p></p>
<?php $form = ActiveForm::begin(['id' => 'form-user-description']); ?>
<table width="100%" border="0" cellspacing="4" cellpadding="4">
    <tr>
        <td>Имя</td>
        <td><?= $form->field($description, 'name')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>Фамилия</td>
        <td><?= $form->field($description, 'soname')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>Телефон</td>
        <td><?= $form->field($description, 'phone')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>Почтовый индекс</td>
        <td><?= $form->field($description, 'code')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>Регион</td>
        <td><?= $form->field($description, 'region')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>Область</td>
        <td><?= $form->field($description, 'country')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>Город</td>
        <td><?= $form->field($description, 'city')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>Адресс</td>
        <td><?= $form->field($description, 'adress')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>Skype</td>
        <td><?= $form->field($description, 'skape')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>Fax</td>
        <td><?= $form->field($description, 'fax')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>ICQ</td>
        <td><?= $form->field($description, 'icq')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td style="vertical-align: middle;">Дополнительная информация</td>
        <td><?= $form->field($description, 'agent')->textarea(['style' => 'width: 240px; height: 70px;'])->label('') ?></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center;"><?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary', 'name' => 'description-button']) ?></td>
    </tr>
</table>
<?php ActiveForm::end(); ?>
