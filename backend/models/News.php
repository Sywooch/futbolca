<?php

namespace backend\models;

use Yii;
use common\UrlHelper;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property string $description
 * @property string $keywords
 * @property string $small
 * @property string $text
 * @property string $created
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    public function beforeValidate()
    {
        if($this->isNewRecord){
            $this->url = UrlHelper::translateUrl($this->name);
            if(!$this->description){
                $this->description = $this->name;
            }
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
            [['name', 'url'], 'required'],
            [['text', 'small'], 'string'],
            [['created'], 'safe'],
            [['name', 'url', 'description', 'keywords'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['url'], 'unique']
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
            'url' => Yii::t('app', 'Url'),
            'description' => Yii::t('app', 'Description'),
            'keywords' => Yii::t('app', 'Keywords'),
            'small' => Yii::t('app', 'Small text'),
            'text' => Yii::t('app', 'Text'),
            'created' => Yii::t('app', 'Created'),
        ];
    }
}
