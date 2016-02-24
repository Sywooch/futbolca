<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
?>
<?=Yii::t('app', 'Здравствуйте')?> <?= Html::encode($user->username) ?>,

<?=Yii::t('app', 'Вы успешно зарегисрировались на сайте  {site}', ['site' => Yii::$app->name])?>:

<?= $resetLink ?>