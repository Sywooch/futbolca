<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\ConvertAsset;
use common\widgets\Alert;

ConvertAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Конвертер',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => Yii::t('app', 'Пользователи'), 'url' => ['/convert']],
    ];
    $menuItems[] = ['label' => Yii::t('app', 'Настройки'), 'url' => ['/convert/settings/index']];
    $menuItems[] = ['label' => Yii::t('app', 'Тексты'), 'items' => [
        ['label' => Yii::t('app', 'Новости (блог)'), 'url' => ['/convert/news/index']],
        ['label' => Yii::t('app', 'Страницы'), 'url' => ['/convert/page/index']],
        ['label' => Yii::t('app', 'Доставка'), 'url' => ['/convert/delivery/index']],
        ['label' => Yii::t('app', 'Размеры'), 'url' => ['/convert/proportion/index']],
        ['label' => Yii::t('app', 'Оплата'), 'url' => ['/convert/paying/index']],
    ]];
    $menuItems[] = ['label' => Yii::t('app', 'Товары'), 'items' => [
        ['label' => Yii::t('app', 'Категории'), 'url' => ['/convert/category/index']],
        ['label' => Yii::t('app', 'Подкатегории'), 'url' => ['/convert/podcategory/index']],
        ['label' => Yii::t('app', 'Метки'), 'url' => ['/convert/marker/index']],
        ['label' => Yii::t('app', 'Фасоны'), 'url' => ['/convert/fashion/index']],
        ['label' => Yii::t('app', 'Основы'), 'url' => ['/convert/element/index']],
        ['label' => Yii::t('app', 'Товары'), 'url' => ['/convert/item/index']],
    ]];
    $menuItems[] = ['label' => Yii::t('app', 'Заказы'), 'items' => [
        ['label' => Yii::t('app', 'Индивидуальный заказ'), 'url' => ['/convert/individual/index']],
        ['label' => Yii::t('app', 'Заказы'), 'url' => ['/convert/podcategory/index']],
    ]];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => Yii::t('yii', 'Пользователи'),
                'url' => \yii\helpers\Url::toRoute(['/convert']),
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?=Yii::$app->name?> Конвертер <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
