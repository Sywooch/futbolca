<?php

namespace backend\models;

use common\CImageHandler;
use common\UrlHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%element}}".
 *
 * @property string $id
 * @property string $name
 * @property string $size
 * @property integer $stock
 * @property integer $home
 * @property string $fashion
 * @property integer $toppx
 * @property integer $leftpx
 * @property integer $price
 * @property integer $increase
 * @property string $photo
 * @property string $image
 *  @property integer $resizeW
 *  @property integer $resizeH
 * @property Fashion $fashion0
 * @property ElementSize $sizes
 */
class Element extends \yii\db\ActiveRecord
{

    public $image;
    public $resizeW;
    public $resizeH;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%element}}';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'photo'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'photo'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name', 'fashion'], 'required'],
            [['stock', 'home', 'fashion', 'toppx', 'leftpx', 'price', 'increase', 'resizeW', 'resizeH'], 'integer'],
            [['name', 'photo'], 'string', 'max' => 255],
//            [['name'], 'unique'],
            [['size'], 'each', 'rule' => ['string']],
            [['image'], 'file', 'extensions' => 'png, jpg, gif, jpeg', 'skipOnEmpty' => true],
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
            'size' => Yii::t('app', 'Size'),
            'stock' => Yii::t('app', 'Stock'),
            'home' => Yii::t('app', 'Основной'),
            'fashion' => Yii::t('app', 'Fashion'),
            'toppx' => Yii::t('app', 'Toppx'),
            'leftpx' => Yii::t('app', 'Leftpx'),
            'price' => Yii::t('app', 'Price'),
            'increase' => Yii::t('app', 'Increase'),
            'photo' => Yii::t('app', 'Photo'),
            'image' => Yii::t('app', 'Image'),
            'resizeW' => Yii::t('app', 'Размер основы высота'),
            'resizeH' => Yii::t('app', 'Размер основы ширина'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFashion0()
    {
        return $this->hasOne(Fashion::className(), ['id' => 'fashion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSizes()
    {
        return $this->hasMany(ElementSize::className(), ['element' => 'id']);
    }

    public function uploadByConver($img, $mini = false){ // _mini
        if(!is_dir(Yii::getAlias('@frontend/web/images/element'))){
            mkdir(Yii::getAlias('@frontend/web/images/element'), 0777);
        }
        if(!is_dir(Yii::getAlias('@frontend/web/images/element/').$this->id)){
            mkdir(Yii::getAlias('@frontend/web/images/element/').$this->id, 0777);
        }
        $imgDirName = Yii::getAlias('@frontend/web/images/element/').$this->id.'/';
        if($mini){
            @copy(str_replace('.jpg', '_mini.jpg', $img), $imgDirName.'mini_'.$this->photo);
        }else{
            @copy($img, $imgDirName.$this->photo);
        }
    }

    public function upload()
    {
        if(!is_dir(Yii::getAlias('@frontend/web/images/element'))){
            mkdir(Yii::getAlias('@frontend/web/images/element'), 0777);
        }
        if(!is_dir(Yii::getAlias('@frontend/web/images/tepm'))){
            mkdir(Yii::getAlias('@frontend/web/images/tepm'), 0777);
        }
        if(!is_dir(Yii::getAlias('@frontend/web/images/element/').$this->id)){
            mkdir(Yii::getAlias('@frontend/web/images/element/').$this->id, 0777);
        }
        $this->deleteImage();
        $nameImg  = UrlHelper::translateUrl($this->image->baseName) . '.' . $this->image->extension;
        $imgDirName = Yii::getAlias('@frontend/web/images/element/').$this->id.'/' . $nameImg;
        $imgDirNameMini = Yii::getAlias('@frontend/web/images/element/').$this->id.'/mini_' . $nameImg;
        $this->image->saveAs(Yii::getAlias('@frontend/web/images/tepm').'/'.$nameImg);
        $ih = new CImageHandler();
        if($this->resizeH || $this->resizeW){
            $this->resizeW = !$this->resizeW ? $this->resizeH : $this->resizeW;
            $this->resizeH = !$this->resizeH ? $this->resizeW : $this->resizeH;
            $ih->load(Yii::getAlias('@frontend/web/images/tepm').'/'.$nameImg)
                ->resize($this->resizeW, $this->resizeH)
                ->save($imgDirName)
                ->reload()
                ->resize(220, 220)
                ->save($imgDirNameMini)
            ;
        }else{
            $ih->load(Yii::getAlias('@frontend/web/images/tepm').'/'.$nameImg)
                ->save($imgDirName);
        }
        @unlink(Yii::getAlias('@frontend/web/images/tepm').'/'.$nameImg);
        return $nameImg;

    }

    public function deleteImage($dir = false){
        @unlink(Yii::getAlias('@frontend/web/images/element/').$this->id.'/' . $this->photo);
        @unlink(Yii::getAlias('@frontend/web/images/element/').$this->id.'/mini_' . $this->photo);
        if($dir){
            @rmdir(Yii::getAlias('@frontend/web/images/element/').$this->id.'/');
        }
    }

    public function getImageLink(){
        return str_replace('/admin/', '', UrlHelper::home(true)).'images/element/'.$this->id.'/'.$this->photo;
    }

    public static function getCatForList(){
        return ArrayHelper::map(self::find()->orderBy("name asc")->all(), 'id', 'name');
    }

    public static function getCatForListForBase(){
        $r = [];
        $models = self::find()->with('fashion0')->orderBy("name asc")->all();
        foreach($models AS $model){
            $r[$model->id] = $model->name. ' (' .$model->fashion0->name.')';
        }
        return $r;
    }

    public static function getCatForListForItem($fashions = []){
        $r = [];
        if($fashions){
            $models = self::find()->with('fashion0')->where(['in', 'fashion', $fashions])->orderBy("name asc")->all();
        }else{
            $models = self::find()->with('fashion0')->orderBy("name asc")->all();
        }
        foreach($models AS $model){
            $r[$model->id] = $model->name.' ('.$model->fashion0->name.') '.Html::img($model->getImageLink(), ['class' => 'img-responsive', 'style' => 'max-width: 60px;']);
        }
        return $r;
    }
}
