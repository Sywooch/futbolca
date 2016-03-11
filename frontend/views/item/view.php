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

$this->title = ($model->description ? $model->description : $model->name);
Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => ($model->keywords ? $model->keywords : $this->title)
]);
Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => ($model->keywords ? $model->keywords : $this->title)
]);
$this->registerJsFile('http://userapi.com/js/api/openapi.js?47', ['position' => \yii\web\View::POS_HEAD]);
$js = <<<JS
    VK.init({apiId: 2778699, onlyWidgets: true});
JS;
$this->registerJs($js, $this::POS_HEAD, 'my-vk-api');
?>
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
        <?=$this->render('block', [
            'model' => $model,
            'items' => $items,
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
    <div id="vk_comments"></div>
    <script type="text/javascript">
        VK.Widgets.Comments("vk_comments", {limit: 5, width: "580", attach: "*"});
    </script>
    <div class="product-descript">

    </div>
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
