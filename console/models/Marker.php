<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%marker}}".
 *
 * @property string $id
 * @property string $old
 * @property integer $position
 * @property string $name
 * @property string $url
 * @property string $description
 * @property string $keywords
 * @property string $text
 * @property string $text2
 *
 * @property ItemMarker[] $itemMarkers
 */
class Marker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%marker}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old', 'position'], 'integer'],
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
            'old' => Yii::t('app', 'Old'),
            'position' => Yii::t('app', 'Position'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'description' => Yii::t('app', 'Description'),
            'keywords' => Yii::t('app', 'Keywords'),
            'text' => Yii::t('app', 'Text'),
            'text2' => Yii::t('app', 'Text2'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemMarkers()
    {
        return $this->hasMany(ItemMarker::className(), ['marker' => 'id']);
    }
}
