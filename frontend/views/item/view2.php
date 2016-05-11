<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Item */
/* @var $item frontend\models\Item */
/* @var $element frontend\models\Element */
/* @var $sizeValue frontend\models\Proportion */
/* @var $watermark frontend\models\ItemWatermark */
/* @var $fashion frontend\models\Fashion */
/* @var $elementItem frontend\models\Element */

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
$this->registerJsFile('http://userapi.com/js/api/openapi.js?47', ['position' => \yii\web\View::POS_HEAD]);
$js = <<<JS
    VK.init({apiId: 2778699, onlyWidgets: true});
JS;
$this->registerJs($js, $this::POS_HEAD, 'my-vk-api');
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
        price: <?=(int)$model->getAllPrice($model->element0)?>,
        priceFull: 0,
        element: <?=(int)$model->element0->id?>,
        fashion: <?=(int)$model->element0->fashion?>,
        item:  <?=(int)$model->id?>,
        watermark: <?=(int)$model->itemWatermarks[0]->id?>,
        size: 0,
        ajaxUrl: '<?=Url::toRoute(['item/block2'])?>',
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
        <?=$this->render('block_new', [
            'model' => $model,
            'elementItem' => $elementItem,
            'currentSize' => $currentSize,
            'currentCount' => $currentCount,
            'currentWatermark' => $currentWatermark,
            'currentFashion' => $currentFashion,
            'size' => $size,
            'elements' => $elements,
            'fashions' => $fashions,
        ])?>
    </div>
    <div class="product-descript">
        <?=$model->text?>
    </div>
    <div id="vk_comments"></div>
    <script type="text/javascript">
        VK.Widgets.Comments("vk_comments", {limit: 5, width: "580", attach: "*"});
    </script>
    <?php if(sizeof($items) > 0){ ?>
        <span class="page-title"><?=Yii::t('app', 'Похожие товары')?></span>
        <?php foreach($items AS $item){ ?>
        <div class="prod-box fl">
            <a href="<?=Url::toRoute(['item/view', 'url' => $item->url])?>" class="prod-title" title="<?=Html::encode($item->name)?>"><?=$item->name?></a>
            <div class="img-wrap"><a href="<?=Url::toRoute(['item/view', 'url' => $item->url])?>" title="<?=Html::encode($item->name)?>"><img src="<?=$item->getImageFromItem()?>" alt="<?=Html::encode($item->name)?>"></a></div>
            <div class="prod-info">
                <a href="<?=Url::toRoute(['item/view', 'url' => $item->url])?>" class="prod-select" title="<?=Html::encode(Yii::t('app', 'Выбрать цвет и размер'))?>"><?=Yii::t('app', 'Выбрать цвет и размер')?></a>
                <span class="price"><?=$item->getAllPrice()?> грн.</span>
            </div>
            <div class="prod-box-top"></div>
            <div class="prod-box-bot"></div>
        </div>
        <?php } ?>
    <?php } ?>
</div>
