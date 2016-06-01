<?php

namespace backend\models;

use backend\models\ItemWatermark;
use common\CImageHandler;
use common\UrlHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
 * @property string $image
 * @property integer $resizeH
 * @property integer $resizeW
 * @property [] $imagePosition
 *
 * @property [] $markers
 * @property [] $categories
 * @property [] $podcategories
 * @property [] $elements
 * @property [] $elementsFilter
 * @property [] $fashions
 *
 * @property Element $element0
 * @property ItemElement[] $itemElements
 * @property ItemMarker[] $itemMarkers
 * @property ItemPodcategory[] $itemPodcategories
 * @property ItemWatermark[]  $watermarks
 * @property ItemCategory[] $itemCategories
 */
class Item extends \yii\db\ActiveRecord
{

    public $image;
    public $resizeW;
    public $resizeH;
    public $markers = [];
    public $categories = [];
    public $podcategories = [];
    public $elements = [];
    public $fashions = [];
    public $elementsFilter = [];
    public $imagePosition = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item}}';
    }

    public function setElements(){
        if(is_array($this->elements) && sizeof($this->elements) > 0){
            $position = Yii::$app->request->post('Item');
            if($position){
                $position = $position['elementsposition'];
            }else{
                $position = [];
            }
            foreach($this->elements AS $elements){
                $elements = (int)$elements;
                if(!$elements){
                    continue;
                }
                $current = new ItemElement();
                $current->item = $this->id;
                $current->element = $elements;
                $current->position = isset($position[$elements]) ? (int)$position[$elements] : 0;
                if($current->validate()){
                    $current->save();
                }
            }
        }
    }

    public function deleteElements(){
        ItemElement::deleteAll("item = :item", [':item' => $this->id]);
    }

    public function getElements(){
        $this->elements = [];
        $this->elements = ArrayHelper::map($this->itemElements, 'element', 'element');
    }

    public function getFashion(){
        $this->elementsFilter = [];
        foreach($this->itemElements AS $el){
            $this->elementsFilter[$el->element0->fashion] = $el->element0->fashion;
        }
    }

    public function setPodcategories(){
        if(is_array($this->podcategories) && sizeof($this->podcategories) > 0){
            foreach($this->podcategories AS $podcategories){
                $podcategories = (int)$podcategories;
                if(!$podcategories){
                    continue;
                }
                $current = new ItemPodcategory();
                $current->item = $this->id;
                $current->podcategory = $podcategories;
                if($current->validate()){
                    $current->save();
                }
            }
        }
    }

    public function deletePodcategories(){
        ItemPodcategory::deleteAll("item = :item", [':item' => $this->id]);
    }

    public function getPodcategories(){
        $this->podcategories = [];
        $this->podcategories = ArrayHelper::map($this->itemPodcategories, 'podcategory', 'podcategory');
    }

    public function setСategories(){
        if(is_array($this->categories) && sizeof($this->categories) > 0){
            foreach($this->categories AS $category){
                $category = (int)$category;
                if(!$category){
                    continue;
                }
                $current = new ItemCategory();
                $current->item = $this->id;
                $current->category = $category;
                if($current->validate()){
                    $current->save();
                }
            }
        }
    }

    public function deleteСategories(){
        ItemCategory::deleteAll("item = :item", [':item' => $this->id]);
    }

    public function getСategories(){
        $this->categories = [];
        $this->categories = ArrayHelper::map($this->itemCategories, 'category', 'category');
    }

    public function setMarkers(){
        if(is_array($this->markers) && sizeof($this->markers) > 0){
            foreach($this->markers AS $marker){
                $marker = (int)$marker;
                if(!$marker){
                    continue;
                }
                $current = new ItemMarker();
                $current->item = $this->id;
                $current->marker = $marker;
                if($current->validate()){
                    $current->save();
                }
            }
        }
    }

    public function deleteMarkers(){
        ItemMarker::deleteAll("item = :item", [':item' => $this->id]);
    }

    public function getMarkers(){
        $this->markers = [];
        $this->markers = ArrayHelper::map($this->itemMarkers, 'marker', 'marker');
    }

    public function beforeValidate()
    {
//        if($this->isNewRecord){
//            if(!$this->url){
//                $this->url = UrlHelper::translateUrl($this->name);
//            }
//            if(!$this->description){
//                $this->description = $this->name;
//            }
//        }else{
//            $this->url = UrlHelper::translateUrl($this->url);
//        }
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'code', 'description', 'keywords', 'text'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'url', 'code', 'description', 'keywords'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name', 'url', 'element'], 'required'],
            [['position', 'element', 'price', 'active', 'home', 'toppx', 'leftpx', 'resizeW', 'resizeH'], 'integer'],
            [['text'], 'string'],
            [['name', 'url', 'code', 'description', 'keywords'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['name'], 'unique'],
            [['image'], 'file', 'extensions' => 'png, jpg, gif, jpeg', 'skipOnEmpty' => true],
            [['markers'], 'each', 'rule' => ['integer']],
            [['categories', 'podcategories', 'elements', 'elementsFilter'], 'each', 'rule' => ['integer']],
            [['imagePosition'], 'each', 'rule' => ['integer']],
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
            'price' => Yii::t('app', 'Наценка'),
            'active' => Yii::t('app', 'Active'),
            'home' => Yii::t('app', 'Home'),
            'toppx' => Yii::t('app', 'Toppx'),
            'leftpx' => Yii::t('app', 'Leftpx'),
            'text' => Yii::t('app', 'Text'),
            'image' => Yii::t('app', 'Wotemark'),
            'resizeW' => Yii::t('app', 'Размер наложения высота'),
            'resizeH' => Yii::t('app', 'Размер наложения ширина'),
            'markers' => Yii::t('app', 'Метки'),
            'categories' => Yii::t('app', 'Категории'),
            'podcategories' => Yii::t('app', 'Подкатегории'),
            'elements' => Yii::t('app', 'Основы'),
            'elementsFilter' => Yii::t('app', 'Фильтр основ по фасонам'),
            'imagePosition' => Yii::t('app', 'Позиция принта'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElement0()
    {
        return $this->hasOne(Element::className(), ['id' => 'element']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemElements()
    {
        return $this->hasMany(ItemElement::className(), ['item' => 'id']);
    }

    public function listElements(){
        $r = [];
        foreach($this->itemElements AS $el){
            $r[] = $el->element0->name.' ('.$el->element0->fashion0->name.')';
        }
        return $r;
    }

    public function listCat(){
        $r = [];
        foreach($this->itemCategories AS $el){
            if(!in_array($el->category0->name, $r)){
                $r[] = $el->category0->name;
            }
        }
        return $r;
    }

    public function listM(){
        $r = [];
        foreach($this->itemMarkers AS $el){
            $r[] = $el->marker0->name;
        }
        return $r;
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
    public function getItemMarkers()
    {
        return $this->hasMany(ItemMarker::className(), ['item' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWatermarks()
    {
        return $this->hasMany(ItemWatermark::className(), ['item' => 'id'])->orderBy('position desc, id asc');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemPodcategories()
    {
        return $this->hasMany(ItemPodcategory::className(), ['item' => 'id']);
    }

    public static function listHome(){
        return [
            2 => Yii::t('app', 'Нет'),
            1 => Yii::t('app', 'Да'),
        ];
    }

    public static function listHomeName($id){
        return isset(self::listHome()[$id]) ? self::listHome()[$id] : null;
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

    public function upload()
    {
        $imgDir = Yii::getAlias('@frontend/web/images');
        $imgDirImage = $imgDir.'/item/';
        if(!is_dir($imgDirImage)){
            mkdir($imgDirImage, 0777);
        }
        if(!is_dir(Yii::getAlias('@frontend/web/images/tepm/'))){
            mkdir(Yii::getAlias('@frontend/web/images/tepm/'), 0777);
        }
        $imageIdDir = $imgDirImage.'/'.$this->id.'/';
        if(!is_dir($imageIdDir)){
            mkdir($imageIdDir, 0777);
        }
        $nameList = [];
        $ih = new CImageHandler();
        if($this->image) {
            foreach ($this->image AS $file) {
                $currentName = $this->id.UrlHelper::translateUrl($file->baseName) . '.' . $file->extension;
                $nameList[] = $currentName;
                $file->saveAs(Yii::getAlias('@frontend/web/images/tepm/') . $currentName);
                if($this->resizeH || $this->resizeW){
                    $this->resizeW = !$this->resizeW ? $this->resizeH : $this->resizeW;
                    $this->resizeH = !$this->resizeH ? $this->resizeW : $this->resizeH;
                    $ih->load(Yii::getAlias('@frontend/web/images/tepm').'/'.$currentName)
                        ->resize($this->resizeW, $this->resizeH)
                        ->save($imageIdDir.$currentName);
                }else{
                    $ih->load(Yii::getAlias('@frontend/web/images/tepm').'/'.$currentName)
                        ->save($imageIdDir.$currentName);
                }
                @unlink(Yii::getAlias('@frontend/web/images/tepm/') . $currentName);
            }
            return $nameList;
        } else {
            return false;
        }
    }

    public function delAllImg($imageIdDir = null){
        $imageIdDir = !$imageIdDir ? Yii::getAlias('@frontend/web/images/item').'/'.$this->id.'/' : $imageIdDir;
        $files = array_diff(scandir($imageIdDir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$imageIdDir/$file")) ? $this->delAllImg("$imageIdDir/$file") : @unlink("$imageIdDir/$file");
        }
        return @rmdir($imageIdDir);
    }

    public function delOneImg($imgName){
        $imageIdDir = Yii::getAlias('@frontend/web/images/item').'/'.$this->id.'/';
        @unlink("$imageIdDir/$imgName");
        return true;
    }

    public function getImageLinkById($id = 0){
        $id = (int)$id;
        if(!$id){
            return $this->getImageLink(0);
        }
        foreach($this->watermarks AS $watermark){
            if($id == $watermark->id){
                return str_replace('/admin/', '', Url::home(true)).'images/item/'.$this->id.'/'.$watermark->name;
            }
        }
        return null;
    }

    public function getImageLink($id = 0){
        if(!isset($this->watermarks[$id])){
            return null;
        }
        return str_replace('/admin/', '', Url::home(true)).'images/item/'.$this->id.'/'.$this->watermarks[$id]->name;
    }

    public function getImageLinks(){
        $r = [];
        foreach($this->watermarks AS $watermark){
            $r[] = str_replace('/admin/', '', Url::home(true)).'images/item/'.$this->id.'/'.$watermark->name;
        }
        return $r;
    }
}
