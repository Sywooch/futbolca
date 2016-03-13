<?php
/**
 * powered by php-shaman
 * index.php 12.03.2016
 * NewFutbolca
 */
/* @var $this yii\web\View */
/* @var $model frontend\models\Item */
/* @var $item frontend\models\CartItem */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Ваш заказ');
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
$allSum = 0;
?>
<?php if(sizeof($items) <= 0){ ?>
    <span class="page-title"><?=Yii::t('app', 'ВАШ ЗАКАЗ')?></span>
    <p style="color: green; font-size: 16px; text-align: center;"><?=Yii::$app->session->getFlash('success')?></p>
    <p><?=Yii::t('app', 'Нет товаров в корзине!')?></p>
<?php }else{ ?>
    <?php $form = ActiveForm::begin([
        'id' => 'cart-form',
        'options' => [
            'accept-charset' => Yii::$app->charset,
        ]
    ]); ?>
    <div class="order">
        <span class="page-title"><?=Yii::t('app', 'ВАШ ЗАКАЗ')?></span>
        <p style="color: green; font-size: 16px; text-align: center;"><?=Yii::$app->session->getFlash('success')?></p>
        <table>
            <tr class="table-header">
                <td><?=Yii::t('app', 'Наименование')?></td>
                <td><?=Yii::t('app', 'Цена')?></td>
                <td><?=Yii::t('app', 'Основа')?></td>
                <td><?=Yii::t('app', 'Принт')?></td>
                <td><?=Yii::t('app', 'Удалить?')?></td>
            </tr>
            <?php foreach($items AS $item){ $price = ((int)$item->item0->getAllPrice($item->element0) * $item->counts); $allSum+= $price; ?>
            <tr>
                <td>
                    <a href="<?=Url::toRoute(['item/view', 'url' => $item->item0->url])?>" class="order-item" target="_blank" title="<?=Html::encode($item->item0->name)?>"><?=$item->item0->name?></a>
                    <dl class="order-list">
                        <dt><?=Yii::t('app', 'Количество')?>:</dt>
                        <dd><input name="count[<?=$item->id?>]" value="<?=$item->counts?>" size="2" type="text"> <?=Yii::t('app', 'шт.')?></dd>
                        <dt><?=Yii::t('app', 'Размер')?>:</dt>
                        <dd><strong><?=$item->size0->name?></strong></dd>
                    </dl>
                </td>
                <td class="order-price"><?=Yii::$app->formatter->asInteger($price)?> грн.</td>
                <td style="vertical-align: middle;"><img src="<?=$item->element0->getImageLink(true)?>" class="maxOneHan" alt="<?=Html::encode($item->element0->name)?>" title="<?=Html::encode($item->element0->name)?>"></td>
                <td style="vertical-align: middle;"><img src="<?=$item->item0->getImageLink($item->watermark, true)?>" class="maxOneHan" alt="<?=Html::encode($item->item0->name)?>" title="<?=Html::encode($item->item0->name)?>"></td>
                <td style="vertical-align: middle;"><input name="CartDelete[<?=$item->id?>]" value="<?=$item->id?>" type="checkbox"></td>
            </tr>
            <?php } ?>
            <tr class="spacing">
                <td colspan="3">
                    <div align="left" style="margin: 5px; display:inline-block;">
                        <input value="<?=Yii::t('app', 'Очистить корзину')?>" class="submit-btn1" id="cartClear" type="button">
                    </div>
                </td>
                <td colspan="2" align="right">
                    <div align="right" style="margin: 5px; display:inline-block;">
                        <input value="<?=Yii::t('app', 'Сохранить')?>" class="submit-btn1" type="submit">
                    </div>
                </td>
            </tr>
            <tr class="table-foot">
                <td colspan="2"><?=Yii::t('app', 'Всего товаров на сумму')?>:</td>
                <td><?=Yii::$app->formatter->asInteger($allSum)?> <?=Yii::t('app', 'грн.')?></td>
                <td colspan="2"></td>
            </tr>
        </table>
        <a href="<?=Url::toRoute(['cart/contents'])?>" class="submit-btn fr" title="<?=Html::encode(Yii::t('app', 'Перейти к оформлению заказа'))?>"><?=Yii::t('app', 'ОФОРМИТЬ ЗАКАЗ')?></a>
        <a href="<?=Url::previous()?>" class="submit-btn fr" title="<?=Html::encode(Yii::t('app', 'Вернуться к товарам'))?>"><?=Yii::t('app', 'ПРОДОЛЖИТЬ ПОКУПКИ')?></a>
    </div>
    <?php ActiveForm::end(); ?>

<?php } ?>

