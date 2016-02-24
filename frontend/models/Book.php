<?php

namespace app\models;

use common\CImageHandler;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%book}}".
 *
 * @property string $id
 * @property string $name
 * @property string $author
 * @property string $date
 * @property string $preview
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Author $author0
 */
class Book extends \yii\db\ActiveRecord
{

    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'date', 'preview'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'date', 'preview'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name', 'author', 'date'], 'required'],
            [['author'], 'integer'],
            [['date'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'preview'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, gif, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Название'),
            'author' => Yii::t('app', 'Автор'),
            'date' => Yii::t('app', 'Дата выхода книги'),
            'preview' => Yii::t('app', 'Превью'),
            'imageFile' => Yii::t('app', 'Превью'),
            'created_at' => Yii::t('app', 'Дата добавления'),
            'updated_at' => Yii::t('app', 'Дата последнего обновления'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(Author::className(), ['id' => 'author']);
    }

    /**
     * @return bool|string
     * @throws \yii\base\Exception
     */
    public function uploadPreview(){
        if ($this->validate()) {
            $ih = new CImageHandler();
            $imgDir = Yii::getAlias('@frontend/web/images/');
            $imgDirMini = Yii::getAlias('@frontend/web/images/mini/');
            $nameImage = $this->id . '.' . $this->imageFile->extension;
            $ih->load($this->imageFile->tempName)
                ->resize(80, 80)
                ->save($imgDirMini.$nameImage)
                ->reload()
                ->save($imgDir.$nameImage);
            return $nameImage;
        } else {
            return false;
        }
    }

    /**
     * @param $img
     */
    public static function deleteImage($img){
        $imgDir = Yii::getAlias('@frontend/web/images/');
        $imgDirMini = Yii::getAlias('@frontend/web/images/mini/');
        @unlink($imgDir.$img);
        @unlink($imgDirMini.$img);
    }

    public function imgUrl($mini = true){
        return Url::home().'images/'.($mini ? 'mini/' : '').$this->preview;
    }
}
