<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\models\HomePage;
use frontend\models\Settings;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Cache-Control" content="max-age=100, must-revalidate">
    <meta name="robots" content="<?=(mb_substr_count($this->title, 404, Yii::$app->charset) > 0)?'noindex,nofollow':'all'?>">
    <meta name="revisit-after" content="1 days">
    <meta name="generator" content="php-shaman">
    <link rel="alternate" type="application/rss+xml" title="rss лента" href="<?=Url::home(true)?>rss.xml">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) .($this->title ? ' | ' : ''). Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="/css/favicon.ico">
    <!--[if lte IE 6]>
    <script src="/js/old/png.js"></script>
    <script>
        DD_belatedPNG.fix('*');
    </script>
    <![endif]-->
    <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
        var CURRENT_DOMEN = '<?=Url::home(true)?>';
        var TV_IN_P = '40';
        /*]]>*/
    </script>
</head>
<body>
<?php $this->beginBody() ?>
<noscript><!--noindex-->Для правильной работы магазина нужно включить JavaScript<!--/noindex--></noscript>
<div id="wrapper">
    <div id="header">
        <div class="logo">
            <a href="<?=Url::home(true)?>" title="Интернет-магазин прикольных футболок"><img src="<?=Url::home(true)?>css/images/logo.png" width="298" height="32" alt="Интернет-магазин прикольных футболок"></a>
            <p>Интернет-магазин прикольной молодежной одежды. Футболки и толстовки на заказ.</p>
        </div>
        <div class="contact">
            <p>Телефоны:</p>
            <span class="contact-item">(066) 371-78-38 (МТС)</span>
            <span class="contact-item">(063) 570-91-83 (Life)</span>
        </div>
        <div class="contact">
            <p>Помощь Online:</p>
            <!--noindex--><a rel="nofollow" href="https://siteheart.com/webconsultation/527725?" target="siteheart_sitewindow_527725" onclick="o=window.open;o('https://siteheart.com/webconsultation/527725?', 'siteheart_sitewindow_527725', 'width=550,height=400,top=30,left=30,resizable=yes'); return false;"><b>Онлайн-консультант</b></a><!--/noindex-->
            <span class="contact-item">shop@futboland.com.ua</span>
        </div>
        <div class="cart">
            <span class="cart-title">Ваша корзина</span>
            <p><strong id="tovrcount">0</strong> <span id="lengv">товаров</span></p>
            <p>на сумму <strong id="tovarsumm">0</strong> грн.</p>
            <a href="<?=Url::home(true)?>user/car.html">Оформить заказ</a>
        </div>
    </div>
    <?=\frontend\widgets\HomeSecondMenu::widget(['urls' => [
        'Доставка и оплата' => 'dostavka',
        'Размеры и качество' => 'sizes',
        'Акции' => 'discounts',
        'Вопрос-ответ' => 'faq',
        'Условия заказа' => 'uslovija-zakaza',
        'Обратная связь' => 'feedback',
    ]])?>
    <div class="nav">
        <ul>
            <li><a href="<?=Url::toRoute(['tags/view', 'url' => 'hit'])?>" title="Хит продаж">Хит продаж</a></li>
            <li><a href="<?=Url::toRoute(['tags/view', 'url' => 'new'])?>" title="Новинки">Новинки</a></li>
            <li><a href="<?=Url::toRoute(['tags/view', 'url' => 'tolstovki'])?>" title="Толстовки">Толстовки</a></li>
            <li><a href="<?=Url::toRoute(['category/view', 'url' => 'dve-futbolki'])?>" title="Парные футболки">Парные футболки</a></li>
            <li><a href="<?=Url::toRoute(['category/view', 'url' => 'woman'])?>" title="Женские майки">Женские майки</a></li>
            <li><a href="<?=Url::toRoute(['category/view', 'url' => 'mamam-papam'])?>" title="Для беременных">Для беременных</a></li>
            <li><a href="<?=Url::toRoute(['page/view', 'url' => 'pechat'])?>" title="Печать на футболках">Печать на футболках</a></li>
        </ul>
        <span class="cl"></span>
        <span class="cr"></span>
    </div>
    <div class="main">
        <div class="sidebar">
            <div class="box">
                <div class="box-title">
                    <span class="heading"><?=Yii::t('app', 'Категории')?></span>
                </div>
                <div class="box-content">
                    <ul class="cat-list">
                        <ul class="cat-list">
                            <?=\frontend\widgets\HomeCat::widget([
                                'categories' => [
                                    'patriotam' => ['name' => 'Патриотам Украины', 'title' => 'Патриотические футболки с украинской символикой'],
                                    'nadpisi' => ['name' => 'Прикольные надписи', 'title' => 'Футболки с прикольными надписями'],
                                    'risunki' => ['name' => 'Прикольные рисунки', 'title' => 'Футболки с прикольными рисунками'],
                                    'dve-futbolki' => ['name' => 'Парные футболки', 'title' => 'Парные футболки для двоих - купить майки для влюбленных пар в Украине'],
                                    'game' => ['name' => 'Для геймеров', 'title' => 'Футболки для геймеров - с логотипами лучших игр - заказать и купить в Украине'],
                                    'semejnye' => ['name' => 'Семейные', 'title' => 'Футболки для всей семьи'],
                                    'fish-hunter' => ['name' => 'Рыбалка и охота', 'title' => 'Футболки для рыбаков и охотников'],
                                    'sport' => ['name' => 'Спортсменам', 'title' => 'Спортивные футболки - купить одежду на спорт тематику в Украине'],
                                    'funny-animals' => ['name' => 'Животные', 'title' => 'Футболки и толстовки с животными'],
                                    'office-work' => ['name' => 'Офис и профессии', 'title' => 'Офис и профессии'],
                                    'ideal-man' => ['name' => 'Идеальный мужчина', 'title' => 'Футболки для идеальных мужчин'],
                                    'woman' => ['name' => 'Для девушек', 'title' => 'Прикольные женские футболки с рисунками и надписями для девушек'],
                                    'for-children' => ['name' => 'Детские', 'title' => 'Детские футболки с прикольными надписями'],
                                    'loveis' => ['name' => 'Love is', 'title' => 'Футболки для влюбленных Love is'],
                                    'music' => ['name' => 'Музыкальные группы', 'title' => 'Музыкальные футболки - купить одежду с музыкальными группами'],
                                    'kino-serialy' => ['name' => 'Кино и сериалы', 'title' => 'Футболки с актерами-персонажами любимых фильмов и сериалов с доставкой по Украине'],
                                    'svadba' => ['name' => 'Свадебные', 'title' => 'Свадебные футболки - заказать прикольные майки на тему свадьбы'],
                                    'mult' => ['name' => 'Мультяшные', 'title' => 'Мультяшные футболки - купить одежду с героями любимых мульфильмов'],
                                    'mamam-papam' => ['name' => 'Для беременных', 'title' => 'Футболки для беременных и для будущих мам и пап - веселые майки для супругов'],
                                    'avto' => ['name' => 'Автомобильные', 'title' => 'Автомобильные майки - купить футболки с автологотипами известных марок'],
                                    'tolstovki-vuzov' => ['name' => 'Толстовки ВУЗов', 'title' => 'Университетские толстовки вузов Украины'],
                                    'imena' => ['name' => 'Имена', 'title' => 'Футболки и толстовки с именами для парней и девушек'],
                                    'army' => ['name' => 'Армия и войска', 'title' => 'Военные и армейские футболки - лучший подарок на 23 февраля'],
                                    'zodiac' => ['name' => 'Знаки зодиака', 'title' => 'Футболки и толстовки со знаками зодиака'],
                                    'design-print' => ['name' => 'Дизайнерские принты', 'title' => 'Дизайнерские футболки'],
                                    'novyj-god' => ['name' => 'Новый год 2015', 'title' => 'Новогодние футболки и толстовки']
                                ],
                            ])?>
                            <li><a href="<?=Url::toRoute(['page/view', 'url' => 'prikol-podarki'])?>" title="Прикольные подарки">Прикольные подарки</a></li>
                        </ul>
                </div>
                <div class="box-bot"></div>
            </div>
            <div class="box">
                <div class="box-title">
                    <span class="heading"><?=Yii::t('app', '3D Одежда')?></span>
                </div>
                <div class="box-content">
                    <ul class="cat-list">
                        <li><a href="<?=Url::toRoute(['category/view', 'url' => '3d-sweatshirts'])?>" title="3D свитшоты">3D свитшоты</a></li>
                        <li><a href="<?=Url::toRoute(['category/view', 'url' => '3d-woman-t-shirt'])?>" title="Женские 3D футболки">Женские 3D футболки</a></li>
                        <li><a href="<?=Url::toRoute(['category/view', 'url' => '3d-man-t-shirt'])?>" title="Мужские 3D футболки">Мужские 3D футболки</a></li>
                        <li><a href="<?=Url::toRoute(['category/view', 'url' => '3d-leggins'])?>" title="3D леггинсы с принтами">3D леггинсы</a></li>
                    </ul>
                </div>
                <div class="box-bot"></div>
            </div>
            <?php if(Yii::$app->user->isGuest){ ?>
            <?=\frontend\widgets\HomeLogin::widget()?>
            <?php } ?>
            <div id="show_version" style="display:none;"></div>
        </div>
        <div class="content">
            <?=$content?>
        </div>
        <div class="sidebar">
            <div class="side-banner">
                <a href="<?=Url::toRoute(['category/view', 'url' => 'dve-futbolki'])?>"><img src="<?=Url::home(true)?>css/baners/banner181.gif" width="181" alt=""></a>
            </div>
            <div class="side-banner">
                <a href="<?=Url::toRoute(['category/view', 'url' => 'imena'])?>"><img src="<?=Url::home(true)?>css/baners/banner183.gif" width="181" alt=""></a>
            </div>
            <div class="side-banner">
                <a href="<?=Url::home()?>individual-order.html" title="Заказать индивидуальную футболку">Индивидуальный заказ</a>
            </div>
            <?=\frontend\widgets\HomeSocial::widget()?>
            <?=\frontend\widgets\HomeSearchForm::widget()?>
            <br>
            <?=\frontend\widgets\HomeNews::widget()?>
        </div>
    </div>
</div>
<div id="footer">
    <div class="footer-inner">
        <?=\frontend\widgets\HomeSecondMenu::widget(['urls' => [
            'Доставка и оплата' => 'dostavka',
            'Размеры и качество' => 'sizes',
            'Акции' => 'discounts',
            'Вопрос-ответ' => 'faq',
            'Условия заказа' => 'uslovija-zakaza',
            'Обратная связь' => 'feedback',
        ]])?>
        <div class="bottom">
            <span class="bottom-title"><?=Yii::t('app', 'Доставка по Украине - в любую точку страны')?></span>
            <?=join(', ', Settings::footerTagsInTag())?>
            <p></p>
        </div>
        <div class="foo-text">
            <?php $homeTxt = HomePage::getToFooter(Url::home(true) == Url::current([], true) ? true : false) ?>
            <?=isset($homeTxt->value) ? $homeTxt->value : ''?>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
