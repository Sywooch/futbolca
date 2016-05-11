<?php
/**
 * powered by php-shaman
 * listElements.php 11.05.2016
 * NewFutbolca
 */

/* @var $model backend\models\Item */
/* @var $form yii\widgets\ActiveForm */

use backend\models\Element;
use backend\models\ItemElement;

$elPos = ItemElement::getPos($model->id);
$postPosition = Yii::$app->request->post('Item');
if($postPosition){
    $postPosition = $postPosition['elementsposition'];
}else{
    $postPosition = $elPos;
}
?>
<div class="row">
    <div class="col-sm-4 col-xs-12">

    </div>
    <div class="col-sm-4 col-xs-12">

    </div>
    <div class="col-sm-4 col-xs-12">
        <small>
            <?=Yii::t('app', 'Можно назначать только тем основам - которые должны быть первыми в своем фасоне')?>
            <br><?=Yii::t('app', '0 - в самом низу')?>
        </small>
    </div>
</div>
<?php foreach(Element::getCatForListForItem($data) AS $idList => $valueList){ ?>
    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <label for="Itemelements<?=$idList?>">
                <input type="checkbox" <?=in_array($idList, $model->elements) ? 'checked' : ''?> name="Item[elements][]" value="<?=$idList?>" id="Itemelements<?=$idList?>">
                <?=$valueList?>
            </label>
        </div>
        <div class="col-sm-4 col-xs-12">
            <input id="item-element-<?=$idList?>" type="radio" name="Item[element]" <?=$model->element == $idList ? 'checked' : ''?> value="<?=$idList?>">
            <label for="item-element-<?=$idList?>"><small><?=Yii::t('app', 'Назначить основной')?></small></label>
        </div>
        <div class="col-sm-4 col-xs-12">
            <label for="item-elementsposition<?=$idList?>"><?=Yii::t('app', 'Позиция')?></label>
            <select class="form-control" name="Item[elementsposition][<?=$idList?>]" id="item-elementsposition<?=$idList?>">
                <?php foreach(Element::listPosition() AS $p){ ?>
                <option value="<?=$p?>" <?=(isset($postPosition[$idList]) && $postPosition[$idList] == $p) ? 'selected="selected"' : ''?>><?=$p?></option>
                <?php } ?>
            </select>
        </div>
    </div>
<?php } ?>
