<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%podcategory}}".
 *
 * @property string $id
 * @property string $category
 * @property integer $position
 * @property string $name
 * @property string $url
 * @property string $description
 * @property string $keywords
 * @property string $text
 * @property string $text2
 *
 * @property ItemPodcategory[] $itemPodcategories
 * @property Category $category0
 */
class Podcategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%podcategory}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'name', 'url'], 'required'],
            [['category', 'position'], 'integer'],
            [['text', 'text2'], 'string'],
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
            'category' => Yii::t('app', 'Category'),
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
    public function getItemPodcategories()
    {
        return $this->hasMany(ItemPodcategory::className(), ['podcategory' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }
}
