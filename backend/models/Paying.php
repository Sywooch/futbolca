<?php

namespace backend\models;

use common\UrlHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%paying}}".
 *
 * @property string $id
 * @property string $name
 * @property string $text
 * @property string $img
 * @property string $image
 */
class Paying extends \yii\db\ActiveRecord
{
    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%paying}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'img'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name'], 'required'],
            [['text'], 'string'],
            [['name', 'img'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['image'], 'file', 'extensions' => 'png, jpg, gif, jpeg'],
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
            'text' => Yii::t('app', 'Text'),
            'img' => Yii::t('app', 'Img'),
            'image' => Yii::t('app', 'Image'),
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs(Yii::getAlias('@frontend/web/paying').'/' . UrlHelper::translateUrl($this->image->baseName) . '.' . $this->image->extension);
            return UrlHelper::translateUrl($this->image->baseName) . '.' . $this->image->extension;
        }
        return false;
    }

    public function deleteImage(){
        @unlink(Yii::getAlias('@frontend/web/paying').'/' . $this->img);
    }

    public function getImageLink(){
        return str_replace('/admin/', '', Url::home(true)).'paying/'.$this->img;
    }

    public static function listPay(){
        return ArrayHelper::map(self::find()->orderBy('id')->all(), 'id', 'name');
    }
}
