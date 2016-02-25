<?php

namespace backend\models;

use common\UrlHelper;
use Yii;

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

    public function upload()
    {
        if(!is_dir(Yii::getAlias('@frontend/web/images/element'))){
            mkdir(Yii::getAlias('@frontend/web/images/element'), 0777);
        }
        if ($this->validate()) {
            if(!is_dir(Yii::getAlias('@frontend/web/images/element/').$this->id)){
                mkdir(Yii::getAlias('@frontend/web/images/element/').$this->id, 0777);
            }
            $this->image->saveAs(Yii::getAlias('@frontend/web/images/element/').$this->id.'/' . UrlHelper::translateUrl($this->image->baseName) . '.' . $this->image->extension);
            return UrlHelper::translateUrl($this->image->baseName) . '.' . $this->image->extension;
        }
        return false;
    }

    public function deleteImage($dir = false){
        @unlink(Yii::getAlias('@frontend/web/images/element/').$this->id.'/' . $this->photo);
        if($dir){
            @rmdir(Yii::getAlias('@frontend/web/images/element/').$this->id.'/');
        }
    }

    public function getImageLink(){
        return str_replace('/admin/', '', UrlHelper::home(true)).'images/element/'.$this->id.'/'.$this->photo;
    }
}
