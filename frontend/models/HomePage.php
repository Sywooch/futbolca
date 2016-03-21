<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%home_page}}".
 *
 * @property string $id
 * @property string $name
 * @property string $value
 * @property string $title
 */
class HomePage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%home_page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value', 'title'], 'filter', 'filter' => 'trim'],
            [['name', 'title'], 'filter', 'filter' => 'strip_tags'],
            [['name'], 'required'],
            [['value'], 'string'],
            [['name', 'title'], 'string', 'max' => 255],
            [['name'], 'unique']
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
            'value' => Yii::t('app', 'Value'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    public static function getToFooter($home = false){
        $footerText = $home ? 'footer_text' : 'footer_text_2' ;
        return self::find()->where("name = :name", [':name' => $footerText])->one();
    }
}
