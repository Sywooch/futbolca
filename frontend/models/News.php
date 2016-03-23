<?php

namespace frontend\models;

use Yii;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'description', 'keywords'], 'filter', 'filter' => 'trim'],
            [['name', 'url', 'description', 'keywords'], 'filter', 'filter' => 'strip_tags'],
            [['name', 'url'], 'required'],
            [['small', 'text'], 'string'],
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
            'small' => Yii::t('app', 'Small'),
            'text' => Yii::t('app', 'Text'),
            'created' => Yii::t('app', 'Created'),
        ];
    }
}
