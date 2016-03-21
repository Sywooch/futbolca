<?php

namespace frontend\models\mg;

use Yii;

/**
 * This is the model class for table "mg_metky".
 *
 * @property string $mt_id
 * @property string $mt_name
 * @property string $mt_uri
 * @property string $mt_description
 * @property string $mt_keywords
 * @property string $mt_text
 * @property string $mt_text2
 */
class Metky extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_metky';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mt_name', 'mt_uri', 'mt_description', 'mt_keywords', 'mt_text', 'mt_text2'], 'required'],
            [['mt_description', 'mt_keywords', 'mt_text', 'mt_text2'], 'string'],
            [['mt_name', 'mt_uri'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mt_id' => Yii::t('app', 'Mt ID'),
            'mt_name' => Yii::t('app', 'Mt Name'),
            'mt_uri' => Yii::t('app', 'Mt Uri'),
            'mt_description' => Yii::t('app', 'Mt Description'),
            'mt_keywords' => Yii::t('app', 'Mt Keywords'),
            'mt_text' => Yii::t('app', 'Mt Text'),
            'mt_text2' => Yii::t('app', 'Mt Text2'),
        ];
    }
}
