<?php

namespace backend\models\old;

use Yii;

/**
 * This is the model class for table "mg_sp".
 *
 * @property string $s_id
 * @property string $s_name
 * @property string $s_uri
 * @property string $s_description
 * @property string $s_keywords
 * @property string $s_text
 * @property string $s_img
 */
class Sp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_sp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['s_name', 's_uri', 's_description', 's_keywords', 's_text', 's_img'], 'required'],
            [['s_description', 's_keywords', 's_text'], 'string'],
            [['s_name', 's_uri', 's_img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            's_id' => Yii::t('app', 'S ID'),
            's_name' => Yii::t('app', 'S Name'),
            's_uri' => Yii::t('app', 'S Uri'),
            's_description' => Yii::t('app', 'S Description'),
            's_keywords' => Yii::t('app', 'S Keywords'),
            's_text' => Yii::t('app', 'S Text'),
            's_img' => Yii::t('app', 'S Img'),
        ];
    }
}
