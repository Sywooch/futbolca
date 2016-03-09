<?php

namespace frontend\models;

use common\UrlHelper;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%individual}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $admintext
 * @property string $img1
 * @property string $img2
 * @property string $img3
 * @property string $img4
 * @property string $created
 * @property array $image
 * @property string $verifyCode
 */
class Individual extends \yii\db\ActiveRecord
{
    public $image;
    public $verifyCode;

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
            [['name', 'phone', 'email', 'comment', 'admintext'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'phone', 'email', 'comment', 'admintext'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name', 'phone', 'email'], 'required'],
            [['status'], 'integer'],
            [['comment', 'admintext'], 'string'],
            [['created'], 'safe'],
            [['name', 'phone', 'email', 'img1', 'img2', 'img3', 'img4'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['image'], 'file', 'extensions' => 'png, jpg, gif, jpeg', 'maxFiles' => 4],
            ['verifyCode', \common\recaptcha\ReCaptchaValidator::className(), 'secret' => \common\recaptcha\ReCaptcha::SECRET_KEY],
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Имя'),
            'status' => Yii::t('app', 'Статус'),
            'phone' => Yii::t('app', 'Телефон'),
            'email' => Yii::t('app', 'Email'),
            'comment' => Yii::t('app', 'Комментарий'),
            'admintext' => Yii::t('app', 'Комментарий админа'),
            'img1' => Yii::t('app', 'Картинка 1'),
            'img2' => Yii::t('app', 'Картинка 2'),
            'img3' => Yii::t('app', 'Картинка 3'),
            'img4' => Yii::t('app', 'Картинка 4'),
            'image' => Yii::t('app', 'Картинка'),
            'created' => Yii::t('app', 'Создано'),
            'verifyCode' => Yii::t('app', 'Я не робот'),
        ];
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
        foreach ($this->image AS $file) {
            $name = UrlHelper::translateUrl($file->baseName) . '.' . $file->extension;
            $file->saveAs($imageIdDir . $name);
            $nameList[] = $name;
        }
        return $nameList;
    }

    public function getImageLink($id){
        if(!$this->{'img'.$id}){
            return null;
        }
        return Url::home(true).'images/individual/'.$this->id.'/'.$this->{'img'.$id};
    }
}
