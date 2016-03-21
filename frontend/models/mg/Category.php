<?php

namespace frontend\models\mg;

use Yii;

/**
 * This is the model class for table "mg_category".
 *
 * @property string $c_position
 * @property string $c_id
 * @property string $c_name
 * @property string $c_uri
 * @property string $c_description
 * @property string $c_keywords
 * @property string $c_text
 * @property string $c_text2
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['c_position'], 'integer'],
            [['c_name', 'c_uri', 'c_description', 'c_keywords', 'c_text', 'c_text2'], 'required'],
            [['c_description', 'c_keywords', 'c_text', 'c_text2'], 'string'],
            [['c_name', 'c_uri'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'c_position' => Yii::t('app', 'C Position'),
            'c_id' => Yii::t('app', 'C ID'),
            'c_name' => Yii::t('app', 'C Name'),
            'c_uri' => Yii::t('app', 'C Uri'),
            'c_description' => Yii::t('app', 'C Description'),
            'c_keywords' => Yii::t('app', 'C Keywords'),
            'c_text' => Yii::t('app', 'C Text'),
            'c_text2' => Yii::t('app', 'C Text2'),
        ];
    }
}
