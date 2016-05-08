<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Item */
/* @var $item frontend\models\Item */
/* @var $element frontend\models\Element */
/* @var $sizeValue frontend\models\Proportion */
/* @var $watermark frontend\models\ItemWatermark */
/* @var $fashion frontend\models\Fashion */

\frontend\assets\ItemAsset::register($this);

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Item;
use yii\helpers\Json;

$this->title = ($model->keywords ? $model->keywords : $model->name);
if(sizeof($model->itemCategories) > 0 && isset($model->itemCategories[0])){
    $firstCat = $model->itemCategories[0];
    $this->params['breadcrumbs'][] = ['label' => $firstCat->category0->name, 'url' => ['category/view', 'url' => $firstCat->category0->url]];
}
$this->params['breadcrumbs'][] = $model->name;
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => ($model->description ? $model->description : $this->title)
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => ($model->description ? $model->description : $this->title)
]);

?>
<div style="display: none;">
    <div id="dialog-error-any" title="<?=Html::encode(Yii::t('app', 'Ошибка'))?>">
        <p>
            <?=Html::encode(Yii::t('app', 'Возникла непонятная ошибка, обновите страницу и попробуйте еще раз!'))?>
        </p>
    </div>
    <div id="dialog-error-count" title="<?=Html::encode(Yii::t('app', 'Неверное количство'))?>">
        <p>
            <?=Html::encode(Yii::t('app', 'Нужно указать количество больше 0'))?>
        </p>
    </div>
    <div id="dialog-error-size" title="<?=Html::encode(Yii::t('app', 'Не указан размер футболки!'))?>">
        <p>
            <?=Html::encode(Yii::t('app', 'Укажите нужный размер футболки, выбрав из доступных!'))?>
        </p>
    </div>
    <div id="dialog-add" title="<?=Html::encode(Yii::t('app', 'Товар успешно добавлен в корзину!'))?>">
        <p>
            <span id="dialog-add-span"></span>
            <?=Html::encode(Yii::t('app', 'Вы можете продолжитьпокупки или перейти к оформлению заказа.'))?>
        </p>
    </div>
    <div id="dialog-add-error" title="<?=Html::encode(Yii::t('app', 'Товар успешно добавлен в корзину!'))?>">
        <p>
            <span id="dialog-add-error-span"></span>
        </p>
    </div>
</div>

<script type="text/javascript">
    /*<![CDATA[*/
    var ItemData = {

        count: 1,
        price: <?=(int)$model->getAllPrice($elementItem)?>,
        priceFull: 0,
        element: <?=(int)$elementItem->id?>,
        fashion: <?=(int)$elementItem->fashion?>,
        item:  <?=(int)$model->id?>,
        watermark: <?=(int)$model->itemWatermarks[0]->id?>,
        size: 0,
        ajaxUrl: '<?=Url::toRoute(['item/block'])?>',
        ajaxCart: '<?=Url::toRoute(['cart/add'])?>',
        hrefCart: '<?=Url::toRoute(['cart/index'])?>',
        setPriceFull: function(newPrice){
            var self = this;
            if(!newPrice){
                newPrice = self.price;
            }
            newPrice = newPrice * 1;
            self.price = newPrice;
            self.priceFull = newPrice * (self.count * 1);
            return self.priceFull;
        }
    };
    ItemData.setPriceFull();
    /*]]>*/
</script>
<div id="tovar_t1">
    <div class="product-block">
        <?=$this->render('block2', [
            'model' => $model,
            'elements' => $elements,
            'fashions' => $fashions,
            'size' => $size,
            'currentFashion' => $currentFashion,
            'currentSize' => $currentSize,
            'currentCount' => $currentCount,
            'currentWatermark' => $currentWatermark,
            'elementItem' => $elementItem,
        ])?>
    </div>
    <div class="product-descript">
        <?=$model->text?>
    </div>
</div>
