<?php

namespace backend\models;

use Yii;
use common\UrlHelper;
use yii\helpers\ArrayHelper;

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
    public function getCategory0()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }

    public static function getCatForList($cat = []){
        if(is_array($cat) && sizeof($cat) > 0){
//            $cat = join('\', \'', $cat);
            return ArrayHelper::map(self::find()->where(['in', "category", $cat])->orderBy("name asc")->all(), 'id', 'name');
        }
        return ArrayHelper::map(self::find()->orderBy("name asc")->all(), 'id', 'name');
    }
}
