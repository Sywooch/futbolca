<?php

namespace backend\models;

use common\UrlHelper;
use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $id
 * @property integer $position
 * @property string $name
 * @property string $url
 * @property string $description
 * @property string $keywords
 * @property string $text
 * @property string $text2
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    public function beforeValidate()
    {
        if($this->isNewRecord){
            $this->url = UrlHelper::translateUrl($this->name);
        }else{
            $this->url = UrlHelper::translateUrl($this->url);
        }
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'keywords', 'description'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'url', 'keywords', 'description'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['position'], 'integer'],
            [['position'], 'default', 'value' => 0],
            [['name', 'url'], 'required'],
            [['text', 'text2'], 'string'],
            [['name', 'url', 'description', 'keywords'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'position' => Yii::t('app', 'Позиция'),
            'name' => Yii::t('app', 'Название'),
            'url' => Yii::t('app', 'Url'),
            'description' => Yii::t('app', 'Description'),
            'keywords' => Yii::t('app', 'Keywords'),
            'text' => Yii::t('app', 'Текст'),
            'text2' => Yii::t('app', 'Дополнительный текст'),
        ];
    }
}
