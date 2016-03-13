<?php
/**
 * powered by php-shaman
 * contents.php 13.03.2016
 * NewFutbolca
 */

/* @var $this yii\web\View */
/* @var $order frontend\models\Order */
/* @var $item frontend\models\CartItem */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Оформить заказ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Моя корзина'), 'url' => ['cart/index']];
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
        $("#order-phone").mask("+38(099)999-99-99");
    });
JS;
$this->registerJs($js, $this::POS_END, 'my-order-phone');

?>
<?php $form = ActiveForm::begin([
    'id' => 'cart-order-form',
    'options' => [
        'accept-charset' => Yii::$app->charset,
    ]
]); ?>
    <h1 class="page-title"><?=$this->title?></h1>
    <p style="text-align: center">Поля помечены <b class="toRec">*</b> обязательны к заполнению!</p>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>Имя <b class="toRec">*</b></td>
            <td><?= $form->field($order, 'name')->textInput(['size' => 35])->label('') ?></td>
        </tr>
        <tr>
            <td>Фамилия <b class="toRec">*</b></td>
            <td><?= $form->field($order, 'soname')->textInput(['size' => 35])->label('') ?></td>
        </tr>
        <tr>
            <td>Телефон <b class="toRec">*</b></td>
            <td><?= $form->field($order, 'phone')->textInput(['size' => 35])->label('') ?></td>
        </tr>
        <tr>
            <td>E-Mail <b class="toRec">*</b></td>
            <td><?= $form->field($order, 'email')->textInput(['size' => 35])->label('') ?></td>
        </tr>
        <tr>
            <td>Адрес <b class="toRec">*</b></td>
            <td><?= $form->field($order, 'adress')->textInput(['size' => 35])->label('') ?></td>
        </tr>
        <tr>
            <td>Почтовый индекс</td>
            <td><?= $form->field($order, 'code')->textInput(['size' => 35])->label('') ?></td>
        </tr>
        <tr>
            <td>Область <b class="toRec">*</b></td>
            <td>
                <?= $form->field($order, 'country')->dropDownList(\frontend\models\Region::getList(), ['prompt' => Yii::t('app', '-- Выберите область --'), 'style' => 'width: 240px;'])->label('') ?>
            </td>
        </tr>
        <tr>
            <td>Город <b class="toRec">*</b></td>
            <td><?= $form->field($order, 'city')->textInput(['size' => 35])->label('') ?></td>
        </tr>
        <tr>
            <td><strong>Выберите способ доставки <b class="toRec">*</b></strong></td>
            <td><?= $form->field($order, 'delivery')->radioList(\frontend\models\Delivery::getListByOrder(), ['encode' => false])->label('') ?></td>
        </tr>
        <tr>
            <td><strong>Способы оплаты <b class="toRec">*</b></strong></td>
            <td><?= $form->field($order, 'payment')->dropDownList(\frontend\models\Paying::getList())->label('') ?></td>
        </tr>
        <tr>
            <td style="vertical-align: middle;">Комментарии</td>
            <td><?= $form->field($order, 'agent')->textarea(['style' => 'width: 250px; height: 80px;'])->label('') ?></td>
        </tr>

        <tr>
            <td colspan=2>
                <p>
                    <strong>
                        Нажимая "<?=Yii::t('app', 'Заказать')?>" Вы подтверждаете, что ознакомились с <a href="<?=Url::toRoute(['page/view', 'url' => 'uslovija-zakaza'])?>" target="blank">условиями заказа</a> и
                        <a href="<?=Url::toRoute(['page/view', 'url' => 'sizes'])?>" target="blank">таблицей размеров</a>.
                    </strong>
                </p>
                <p style="text-align: center"><input type="submit" value="<?=Yii::t('app', 'Заказать')?>"></p></td>
        </tr>
    </table>
<?php ActiveForm::end(); ?>
