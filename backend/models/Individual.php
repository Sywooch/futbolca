<?php

namespace backend\models;

use common\UrlHelper;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%individual}}".
 *
 * @property string $id
 * @property string $name
 * @property string $status
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $img1
 * @property string $img2
 * @property string $img3
 * @property string $img4
 * @property array $image
 * @property string $created
 */
class Individual extends \yii\db\ActiveRecord
{

    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%individual}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email', 'img1', 'img2', 'img3', 'img4', 'comment'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'phone', 'email', 'img1', 'img2', 'img3', 'img4', 'comment'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name', 'phone', 'email'], 'required'],
            [['comment'], 'string'],
            [['status'], 'integer'],
            [['created'], 'safe'],
            [['name', 'phone', 'email', 'img1', 'img2', 'img3', 'img4'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['image'], 'file', 'extensions' => 'png, jpg, gif, jpeg', 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Username'),
            'status' => Yii::t('app', 'Status'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'comment' => Yii::t('app', 'Comment'),
            'img1' => Yii::t('app', 'Img1'),
            'img2' => Yii::t('app', 'Img2'),
            'img3' => Yii::t('app', 'Img3'),
            'img4' => Yii::t('app', 'Img4'),
            'image' => Yii::t('app', 'Image'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    public static function listStatus(){
        return [
            1 => Yii::t('app', 'в обработке'),
            2 => Yii::t('app', 'выполняется'),
            3 => Yii::t('app', 'на доставку'),
            4 => Yii::t('app', 'отправлен'),
            5 => Yii::t('app', 'получен'),
            6 => Yii::t('app', 'не дозвонились'),
            7 => Yii::t('app', 'отменен'),
            8 => Yii::t('app', 'не оформлен'),
            9 => Yii::t('app', 'ожидает оплату'),
            10 => Yii::t('app', 'выполнен')
        ];
    }

    public static function getStatusName($id){
        return isset(self::listStatus()[$id]) ? self::listStatus()[$id] : null;
    }

    public function upload()
    {
        $imgDir = Yii::getAlias('@frontend/web/images');
        $imgDirImage = $imgDir.'/individual/';
        if(!is_dir($imgDirImage)){
            mkdir($imgDirImage, 0777);
        }
        $imageIdDir = $imgDirImage.'/'.$this->id.'/';
        if(!is_dir($imageIdDir)){
            mkdir($imageIdDir, 0777);
        }
        $nameList = [];
        if ($this->validate()) {
            foreach ($this->image AS $file) {
                $file->saveAs($imageIdDir . UrlHelper::translateUrl($file->baseName) . '.' . $file->extension);
                $nameList[] = UrlHelper::translateUrl($file->baseName) . '.' . $file->extension;
            }
            return $nameList;
        } else {
            return false;
        }
    }

    public function delAllImg($imageIdDir = null){
        $imageIdDir = !$imageIdDir ? Yii::getAlias('@frontend/web/images/individual').'/'.$this->id.'/' : $imageIdDir;
        $files = array_diff(scandir($imageIdDir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$imageIdDir/$file")) ? $this->delAllImg("$imageIdDir/$file") : @unlink("$imageIdDir/$file");
        }
        return @rmdir($imageIdDir);
    }

    public function getImageLink($id){
        return str_replace('/admin/', '', Url::home(true)).'images/individual/'.$this->id.'/'.$this->{'img'.$id};
    }
}
