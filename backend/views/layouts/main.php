<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="php-shaman">
    <meta name="generator" content="php-shaman">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title . ' | ' . Yii::$app->name) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="/admin/css/favicon.ico">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => Yii::t('app', 'Главная'), 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Вход'), 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['/user/index']];
        $menuItems[] = ['label' => Yii::t('app', 'Категории'), 'items' => [
            ['label' => Yii::t('app', 'Категории'), 'url' => ['/category/index']],
            ['label' => Yii::t('app', 'Подкатегории'), 'url' => ['/podcategory/index']],
            ['label' => Yii::t('app', 'Метки'), 'url' => ['/marker/index']],
        ]];
        $menuItems[] = ['label' => Yii::t('app', 'Товары'), 'items' => [
            ['label' => Yii::t('app', 'Фасоны'), 'url' => ['/fashion/index']],
            ['label' => Yii::t('app', 'Основы'), 'url' => ['/element/index']],
            ['label' => Yii::t('app', 'Товары'), 'url' => ['/item/index']],
        ]];
        $menuItems[] = ['label' => Yii::t('app', 'Заказы'), 'items' => [
            ['label' => Yii::t('app', 'Индивидуальные заказы'), 'url' => ['/individual/index']],
        ]];
        $menuItems[] = ['label' => Yii::t('app', 'Тексты'), 'items' => [
            ['label' => Yii::t('app', 'Размеры'), 'url' => ['/proportion/index']],
            ['label' => Yii::t('app', 'Доставка'), 'url' => ['/delivery/index']],
            ['label' => Yii::t('app', 'Способы оплаты'), 'url' => ['/paying/index']],
            ['label' => Yii::t('app', 'Стат страницы'), 'url' => ['/page/index']],
            ['label' => Yii::t('app', 'Новости'), 'url' => ['/news/index']],
        ]];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                Yii::t('app', 'Выход ({user})', ['user' => Yii::$app->user->identity->username]),
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?=Yii::$app->name?> <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
