<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $user \frontend\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Настройки e-mail, логина и пароля');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => $this->title
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title
]);
?>

<h1 class="page-title"><?=Yii::t('app', 'Настройки e-mail, логина и пароля')?></h1>
<p style="text-align: center; color:green;"><?= Yii::$app->session->getFlash('success')?></p>
<p style="text-align: center; color:red;"><?= Yii::$app->session->getFlash('error')?></p>
<p></p>
<?php $form = ActiveForm::begin(['id' => 'form-user-info']); ?>
<table width="100%" border="0" cellspacing="4" cellpadding="4">
    <tr>
        <td>Логин <b class="toRec">*</b></td>
        <td><?= $form->field($user, 'username')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>E-mail <b class="toRec">*</b></td>
        <td><?= $form->field($user, 'email')->textInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td>Пароль</td>
        <td><?= $form->field($user, 'password')->passwordInput(['size' => 35])->label('')->hint(Yii::t('app', 'Оставить пустым, если не нужно изменять')) ?></td>
    </tr>
    <tr>
        <td>Пароль еще раз</td>
        <td><?= $form->field($user, 'password_to')->passwordInput(['size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td> </td>
        <td><br></td>
    </tr><tr>
        <td>Текущий пароль <b class="toRec">*</b></td>
        <td><?= $form->field($user, 'currentPassword')->passwordInput(['value' => '','size' => 35])->label('') ?></td>
    </tr>
    <tr>
        <td> </td>
        <td><?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary', 'name' => 'description-button']) ?></td>
    </tr>
</table>
<?php ActiveForm::end(); ?>
