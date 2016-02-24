<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<?=Yii::t('app', 'Здравствуйте')?> <?= $user->username ?>,

<?=Yii::t('app', 'Следуйте по ссылке для восстановления пароля')?>:

<?= $resetLink ?>
