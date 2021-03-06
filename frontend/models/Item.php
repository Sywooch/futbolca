<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%item}}".
 *
 * @property string $id
 * @property string $old
 * @property string $name
 * @property integer $position
 * @property string $url
 * @property string $element
 * @property string $code
 * @property string $description
 * @property string $keywords
 * @property integer $price
 * @property integer $active
 * @property integer $home
 * @property integer $toppx
 * @property integer $leftpx
 * @property string $text
 *
 * @property Element $element0
 * @property ItemCategory[] $itemCategories
 * @property ItemElement[] $itemElements
 * @property ItemMarker[] $itemMarkers
 * @property ItemPodcategory[] $itemPodcategories
 * @property ItemWatermark[] $itemWatermarks
 * @property OrderItem[] $orderItems
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'code', 'description', 'keywords'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'url', 'code', 'description', 'keywords'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name', 'url', 'element'], 'required'],
            [['position', 'element', 'price', 'active', 'home', 'toppx', 'leftpx', 'old'], 'integer'],
            [['text'], 'string'],
            [['name', 'url', 'code', 'description', 'keywords'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'position' => Yii::t('app', 'Position'),
            'url' => Yii::t('app', 'Url'),
            'element' => Yii::t('app', 'Element'),
            'code' => Yii::t('app', 'Code'),
            'description' => Yii::t('app', 'Description'),
            'keywords' => Yii::t('app', 'Keywords'),
            'price' => Yii::t('app', 'Price'),
            'active' => Yii::t('app', 'Active'),
            'home' => Yii::t('app', 'Home'),
            'toppx' => Yii::t('app', 'Toppx'),
            'leftpx' => Yii::t('app', 'Leftpx'),
            'text' => Yii::t('app', 'Text'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElement0()
    {
        return $this->hasOne(Element::className(), ['id' => 'element'])->with(['fashion0']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemCategories()
    {
        return $this->hasMany(ItemCategory::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemElements()
    {
        return $this->hasMany(ItemElement::className(), ['item' => 'id'])->orderBy('position asc');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemMarkers()
    {
        return $this->hasMany(ItemMarker::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemPodcategories()
    {
        return $this->hasMany(ItemPodcategory::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemWatermarks()
    {
        return $this->hasMany(ItemWatermark::className(), ['item' => 'id'])->orderBy('position desc, id asc');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['item' => 'id']);
    }

    public function getImageFromItem($currentWatermark = 0, $elementItem = null, $pre = null){
        $currentWatermark = (int)$currentWatermark;
        if($currentWatermark > 0){
            $watemark = null;
            foreach($this->itemWatermarks AS $watermark){
                if($watermark->id == $currentWatermark){
                    $watemark = $watermark->name;
                }
            }
        }else{
            $watemark = isset($this->itemWatermarks[0]->name) ? $this->itemWatermarks[0]->name : null;
        }
        if(!$watemark){
            return null;
        }
        $watemark = explode('.', $watemark);
        $watemark = $watemark[0];
        if($elementItem){
            $element = $elementItem->photo;
        }else{
            $element = isset($this->element0->photo) ? $this->element0->photo : null;
        }
        if(!$element){
            return null;
        }
        $element = explode('.', $element);
        $element = $element[0];
        if($pre){
            $url = Url::toRoute([
                'image/preview',
                'type' => 'full',
                'element' => $element,
                'water' => $watemark,
                'top' => (int)($this->element0->toppx + $this->toppx),
                'left' => (int)($this->element0->leftpx  + $this->leftpx),
            ]);
        }else{
            $url = Url::toRoute([
                'image/create',
                'type' => 'full',
                'element' => $element,
                'water' => $watemark,
                'top' => (int)($this->element0->toppx + $this->toppx),
                'left' => (int)($this->element0->leftpx  + $this->leftpx),
            ]);
        }

        return $url;
    }

    public function getAllPrice($elementItem = null){
        if(!$elementItem){
            $elementItem = $this->element0;
        }
        if($elementItem->price > 0){
            return $elementItem->price + $this->price;
        }
        $price = $this->price;
        $price += $elementItem->increase;
        $price += $elementItem->fashion0->price;
        return $price;
    }

    public static function getElementsForItemPage($model){
        $minBetween = $model->id - 100;
        if ($minBetween < 1) {
            $minBetween = 1;
        }
        $maxBetween = $model->id + 100;
        $cat = ArrayHelper::map($model->itemCategories, 'category', 'category');
        return self::find()
            ->with(['element0', 'itemWatermarks'])
            ->innerJoin('{{%item_category}}', '{{%item_category}}.item = {{%item}}.id')
            ->where(['in', "{{%item_category}}.category", $cat])
            ->andWhere("{{%item}}.id <> :id", [':id' => $model->id])
            ->andWhere("{{%item}}.id BETWEEN :id2 AND :id3", [':id2' => $minBetween, ':id3' => $maxBetween])
            ->orderBy('{{%item}}.position desc')
            ->limit(2)
            ->offset(rand(1, 3))
            ->all();
    }

    public static function photoNoExp($name){
        $name = explode('.', $name);
        return isset($name[0]) ? $name[0] : null;
    }

    public static function toJson($model){
        $model->description = '';
        $model->keywords = '';
        $model->text = '';
        return $model;
    }

    public function getImageLink($id = 0, $mini = false){
        foreach($this->itemWatermarks AS $watermark){
            if($watermark->id == $id){
                return Url::home(true).'images/item/'.$this->id.'/'.($mini ? 'mini_' : '').$watermark->name;
            }
        }
        return null;
    }

    public function getImageLinks(){
        $r = [];
        foreach($this->itemWatermarks AS $watermark){
            $r[] = str_replace('/admin/', '', Url::home(true)).'images/item/'.$this->id.'/'.$watermark->name;
        }
        return $r;
    }

    public function hasPhoto($photoName, $mini = false){
        $imgDir = Yii::getAlias('@frontend/web/images/item/').$this->id.'/';
        if($mini){
            $imgDir .= 'mini_'.$photoName;
        }else{
            $imgDir .= $photoName;
        }
        return is_file($imgDir);
    }

    public function uploadByConver($img, $photoName, $mini = false){
        $imgDir = Yii::getAlias('@frontend/web/images');
        $imgDirImage = $imgDir.'/item/';
        if(!is_dir($imgDirImage)){
            mkdir($imgDirImage, 0777);
        }
        $imageIdDir = $imgDirImage.'/'.$this->id.'/';
        if(!is_dir($imageIdDir)){
            mkdir($imageIdDir, 0777);
        }
        if($mini){
            @copy(str_replace('.png', '_mini.png', $img), $imageIdDir.'mini_'.$photoName);
        }else{
            @copy($img, $imageIdDir.$photoName);
        }
    }
}
