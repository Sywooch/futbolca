<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%item}}".
 *
 * @property string $id
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
            [['name', 'url', 'element'], 'required'],
            [['position', 'element', 'price', 'active', 'home', 'toppx', 'leftpx'], 'integer'],
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
        return $this->hasMany(ItemElement::className(), ['item' => 'id']);
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
        return $this->hasMany(ItemWatermark::className(), ['item' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['item' => 'id']);
    }

    public function getImageFromItem(){
        $watemark = isset($this->itemWatermarks[0]->name) ? $this->itemWatermarks[0]->name : null;
        if(!$watemark){
            return null;
        }
        $watemark = explode('.', $watemark);
        $watemark = $watemark[0];
        $element = isset($this->element0->photo) ? $this->element0->photo : null;
        if(!$element){
            return null;
        }
        $element = explode('.', $element);
        $element = $element[0];

    }

    public function getAllPrice(){
        if($this->element0->price > 0){
            return $this->element0->price + $this->price;
        }
        $price = $this->price;
        $price += $this->element0->increase;
        $price += $this->element0->fashion0->price;
        return $price;
    }
}
